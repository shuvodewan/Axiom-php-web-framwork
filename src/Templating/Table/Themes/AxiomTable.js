class AxiomTable {
    constructor(config) {
        this.config = config;
        this.tableElement = document.getElementById(`${config.id}-container`);
        this.currentPage = 1;
        this.sortColumn = config.defaultSort[0] || '';
        this.sortDirection = config.defaultSort[1] || 'asc';
        this.filters = {};
        
        this.init();
    }

    init() {
        this.bindEvents();
        
        if (this.config.serverSide) {
            this.loadData();
        } else {
            this.renderData(this.config.data);
        }
    }

    bindEvents() {
        // Sortable headers
        this.tableElement.querySelectorAll('[data-sort]').forEach(header => {
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sort');
                this.sort(column);
            });
        });

        // Filter inputs
        this.tableElement.querySelectorAll('[data-filter]').forEach(input => {
            input.addEventListener('change', (e) => {
                this.filters[e.target.getAttribute('data-filter')] = e.target.value;
            });
        });

        // Filter buttons
        const applyBtn = this.tableElement.querySelector('[data-action="apply-filters"]');
        const resetBtn = this.tableElement.querySelector('[data-action="reset-filters"]');
        
        if (applyBtn) applyBtn.addEventListener('click', () => this.applyFilters());
        if (resetBtn) resetBtn.addEventListener('click', () => this.resetFilters());

        // Pagination
        this.tableElement.addEventListener('click', (e) => {
            if (e.target.hasAttribute('data-page')) {
                this.goToPage(parseInt(e.target.getAttribute('data-page')));
            }
        });

        // Bulk actions
        const bulkActionSelect = this.tableElement.querySelector('[data-bulk-action]');
        if (bulkActionSelect) {
            bulkActionSelect.addEventListener('change', (e) => {
                this.executeBulkAction(e.target.value);
            });
        }
    }

    async loadData() {
        this.showLoading();
        
        try {
            const params = {
                page: this.currentPage,
                perPage: this.config.perPage,
                sort: this.sortColumn,
                direction: this.sortDirection,
                filters: this.filters
            };

            const response = await fetch(this.config.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(params)
            });

            const data = await response.json();
            this.renderData(data);
        } catch (error) {
            console.error('Error loading table data:', error);
            this.showError();
        }
    }

    renderData(data) {
        const tbody = this.tableElement.querySelector('tbody');
        tbody.innerHTML = '';

        if (data.data && data.data.length > 0) {
            data.data.forEach(row => {
                const tr = document.createElement('tr');
                tr.className = this.config.theme.rowClasses;
                
                // Bulk select checkbox
                if (this.config.bulkActions.length > 0) {
                    const td = document.createElement('td');
                    td.className = this.config.theme.cellClasses;
                    td.innerHTML = `<input type="checkbox" data-row-id="${row.id}">`;
                    tr.appendChild(td);
                }
                
                // Data columns
                this.config.columns.forEach(column => {
                    const td = document.createElement('td');
                    td.className = this.config.theme.cellClasses;
                    
                    // Handle nested properties (e.g., 'roles.title')
                    const value = column.name.split('.').reduce((obj, key) => 
                        (obj && obj[key] !== undefined) ? obj[key] : null, row);
                    
                    td.textContent = value !== null ? value : '';
                    tr.appendChild(td);
                });
                
                // Actions
                if (this.config.actions.length > 0) {
                    const td = document.createElement('td');
                    td.className = `${this.config.theme.cellClasses} text-right`;
                    
                    const actionsDiv = document.createElement('div');
                    actionsDiv.className = 'flex justify-end space-x-2';
                    
                    this.config.actions.forEach(action => {
                        const btn = document.createElement('button');
                        btn.className = this.config.theme.actionButtonClasses;
                        btn.innerHTML = action.icon ? `${action.icon} ${action.label}` : action.label;
                        
                        // Replace placeholders in URL (e.g., {id})
                        let url = action.url;
                        for (const key in row) {
                            url = url.replace(`{${key}}`, row[key]);
                        }
                        
                        if (action.confirm) {
                            btn.addEventListener('click', () => {
                                if (confirm(action.confirm)) {
                                    this.executeAction(action.method, url);
                                }
                            });
                        } else {
                            btn.addEventListener('click', () => this.executeAction(action.method, url));
                        }
                        
                        actionsDiv.appendChild(btn);
                    });
                    
                    td.appendChild(actionsDiv);
                    tr.appendChild(td);
                }
                
                tbody.appendChild(tr);
            });
        } else {
            this.showEmptyState();
        }

        this.updatePagination(data);
    }

    updatePagination(data) {
        const paginationInfo = this.tableElement.querySelector('.pagination-info');
        const paginationLinks = this.tableElement.querySelector('.pagination-links');
        
        if (paginationInfo) {
            const start = ((data.current_page - 1) * data.per_page) + 1;
            const end = Math.min(start + data.per_page - 1, data.total);
            
            paginationInfo.textContent = 
                `${this.config.i18n.showing} ${start} ${this.config.i18n.to} ${end} ` +
                `${this.config.i18n.of} ${data.total} ${this.config.i18n.results}`;
        }

        if (paginationLinks) {
            paginationLinks.innerHTML = '';
            
            // Previous button
            if (data.current_page > 1) {
                const prevBtn = this.createPaginationButton(
                    'previous', 
                    this.config.i18n.previous,
                    data.current_page - 1
                );
                paginationLinks.appendChild(prevBtn);
            }

            // Page numbers
            const maxVisible = 5;
            let startPage = Math.max(1, data.current_page - Math.floor(maxVisible / 2));
            let endPage = Math.min(data.last_page, startPage + maxVisible - 1);
            
            if (endPage - startPage + 1 < maxVisible) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = this.createPaginationButton(
                    i.toString(), 
                    i.toString(),
                    i,
                    i === data.current_page
                );
                paginationLinks.appendChild(pageBtn);
            }

            // Next button
            if (data.current_page < data.last_page) {
                const nextBtn = this.createPaginationButton(
                    'next', 
                    this.config.i18n.next,
                    data.current_page + 1
                );
                paginationLinks.appendChild(nextBtn);
            }
        }
    }

    createPaginationButton(id, text, page, isActive = false) {
        const button = document.createElement('button');
        button.setAttribute('data-page', page);
        button.className = isActive 
            ? this.config.theme.activePaginationButtonClasses 
            : this.config.theme.paginationButtonClasses;
        button.textContent = text;
        return button;
    }

    showLoading() {
        const tbody = this.tableElement.querySelector('tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="${this.config.columns.length + 
                    (this.config.bulkActions.length ? 1 : 0) + 
                    (this.config.actions.length ? 1 : 0)}">
                    ${this.config.theme.loadingIndicator}
                </td>
            </tr>
        `;
    }

    showEmptyState() {
        const tbody = this.tableElement.querySelector('tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="${this.config.columns.length + 
                    (this.config.bulkActions.length ? 1 : 0) + 
                    (this.config.actions.length ? 1 : 0)}">
                    ${this.config.theme.emptyState}
                </td>
            </tr>
        `;
    }

    showError() {
        const tbody = this.tableElement.querySelector('tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="${this.config.columns.length + 
                    (this.config.bulkActions.length ? 1 : 0) + 
                    (this.config.actions.length ? 1 : 0)}" 
                    class="text-center text-red-500">
                    Error loading data. Please try again.
                </td>
            </tr>
        `;
    }

    sort(column) {
        if (this.sortColumn === column) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortColumn = column;
            this.sortDirection = 'asc';
        }
        
        if (this.config.serverSide) {
            this.loadData();
        } else {
            this.applyClientSideSorting();
        }
    }

    applyClientSideSorting() {
        const data = this.config.data.data.slice(); // Create a copy
        
        data.sort((a, b) => {
            const valA = this.getNestedValue(a, this.sortColumn);
            const valB = this.getNestedValue(b, this.sortColumn);
            
            if (valA < valB) return this.sortDirection === 'asc' ? -1 : 1;
            if (valA > valB) return this.sortDirection === 'asc' ? 1 : -1;
            return 0;
        });
        
        this.config.data.data = data;
        this.renderData(this.config.data);
    }

    getNestedValue(obj, path) {
        return path.split('.').reduce((o, key) => (o && o[key] !== undefined) ? o[key] : '', obj);
    }

    applyFilters() {
        this.currentPage = 1;
        
        if (this.config.serverSide) {
            this.loadData();
        } else {
            this.applyClientSideFiltering();
        }
    }

    applyClientSideFiltering() {
        const filteredData = this.config.data.data.filter(row => {
            return Object.entries(this.filters).every(([key, value]) => {
                if (!value) return true;
                
                const rowValue = this.getNestedValue(row, key);
                return String(rowValue).toLowerCase().includes(String(value).toLowerCase());
            });
        });
        
        this.config.data.data = filteredData;
        this.config.data.total = filteredData.length;
        this.config.data.last_page = Math.ceil(filteredData.length / this.config.perPage);
        this.renderData(this.config.data);
    }

    resetFilters() {
        this.filters = {};
        this.currentPage = 1;
        
        if (this.config.serverSide) {
            this.loadData();
        } else {
            // Reset to original data
            this.config.data = this.prepareClientSideData(this.originalData);
            this.renderData(this.config.data);
        }
    }

    goToPage(page) {
        this.currentPage = page;
        
        if (this.config.serverSide) {
            this.loadData();
        } else {
            this.renderData(this.config.data);
        }
    }

    executeAction(method, url) {
        // Implement action execution (e.g., redirect or API call)
        if (method === 'GET') {
            window.location.href = url;
        } else {
            // Handle POST, DELETE, etc.
            fetch(url, { method })
                .then(response => {
                    if (response.ok) {
                        this.loadData(); // Refresh table
                    }
                });
        }
    }

    executeBulkAction(action) {
        const selectedIds = Array.from(
            this.tableElement.querySelectorAll('input[type="checkbox"]:checked')
        ).map(checkbox => checkbox.getAttribute('data-row-id'));
        
        if (selectedIds.length === 0) return;
        
        // Find the bulk action config
        const bulkAction = this.config.bulkActions.find(a => a.name === action);
        if (!bulkAction) return;
        
        if (bulkAction.confirm && !confirm(bulkAction.confirm)) {
            return;
        }
        
        // Execute bulk action
        fetch(bulkAction.url, {
            method: bulkAction.method || 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ids: selectedIds })
        }).then(response => {
            if (response.ok) {
                this.loadData(); // Refresh table
            }
        });
    }
}

// Make it available globally
if (typeof window !== 'undefined') {
    window.AxiomTable = AxiomTable;
}