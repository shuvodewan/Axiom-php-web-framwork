

function isObject(value) {
    return value !== null && typeof value === 'object' && !Array.isArray(value);
}

const processForm = (formData,form,deep,key,data=null,prev=null)=>{
    if (form.hasOwnProperty(key)) {
        data = form[key];
    }
    if (Array.isArray(data) && deep) {
        return data.forEach((item,index)=>{
            processForm(formData,form,deep,`${key}[${index}]`,item)
        })
    }

    if(data && data.constructor === File){
        // console.log(data,'ddd')
        return formData.append(key,data);
    }

    if(isObject(data)){
        // console.log(data)
        return Object.keys(data).forEach(item=>{
            processForm(formData,form,deep,`${key}[${item}]`,data[item])
        })

    }

    formData.append(key,data??'');

}



const formDataConverter = (data,deeper=false)=>{
    let formdata=new FormData()
    let form=data
    let deep=deeper
    for (const key in form) {
        processForm(formdata,form,deep,key)
    }
    return formdata
}
