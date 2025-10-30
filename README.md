# 🚀 Axiom Framework

> **Note:** This project is currently **looking for maintainers!**  
> Axiom is a promising PHP framework that combines **Laravel’s flexibility** with **Django’s modularity**.  
> The original author has moved on, but the foundation is solid and ready for community development.

---

## 📋 Project Status

| Status | Description |
|:------:|--------------|
| 🟡 **Seeking Maintainers** | Looking for active contributors and maintainers |
| ⚙️ **Current State** | Foundation complete, some core features need implementation |
| 💡 **Opportunity** | Perfect for developers who want to lead an open-source framework |

---

## ✨ What is Axiom?

**Axiom** is a modern PHP framework that masterfully blends:

- **Laravel's developer experience** — Elegant syntax, great DX  
- **Django's modular architecture** — Self-contained, reusable apps  
- **Enterprise-ready foundation** — Doctrine ORM, modern tooling  

---

## 🏗️ Architecture Highlights

### Modular App System (Django-Inspired)
```
app/
├── Authentication/     # Auth module (needs completion)
├── Dashboard/          # Admin dashboard  
├── Blog/               # Example blog module
├── Ecommerce/          # Potential e-commerce module
└── [Your Module]       # Create anything!
```

### Hybrid ORM System
**Doctrine Data Mapper + Active Record pattern**

- Best of both worlds: power + convenience  
- Fluent query builder with relationship management  

---

## ⚙️ Modern Tech Stack

### Backend
- PHP 8.0+
- Doctrine ORM  
- Twig Templating  
- Symfony Components  

### Frontend
- Vite build tool  
- Tailwind CSS  
- Alpine.js  
- PostCSS  

---

## 🎯 What's Already Working

### ✅ Complete Features
- **CLI System (`php axiom`)** — Artisan-like commands  
- **Code Generators** — Scaffold modules, entities, controllers  
- **Database Migrations** — Full migration system  
- **Modular Architecture** — Self-contained apps  
- **Twig Templating** — With extensions and filters  
- **Form & Table Builders** — Themeable UI components  
- **Validation System** — Request validation  
- **Mail System** — Multiple transport support  
- **File Storage** — Local & S3 drivers  
- **Caching** — File & Redis drivers  

### 🧩 Command Examples
```bash
# Module management
php axiom app:create Blog
php axiom app:entity Post
php axiom app:controller PostController

# Database
php axiom migrations:migrate
php axiom seeder:populate

# Development
php axiom project:start
php axiom cache:clear
```

---

## 🚧 What Needs Implementation

### 🔴 High Priority
- Authentication System  
  - User registration/login  
  - Password reset  
  - Email verification  
  - Session management  
- Authorization System  
  - Role-based permissions  
  - Policy system  
  - Middleware protection  
- Task Queue System  
  - Job processing  
  - Failed job handling  
  - Queue monitoring  
  - Worker management  

### 🟡 Medium Priority
- Testing Suite (PHPUnit integration)  
- API Documentation (OpenAPI/Swagger)  
- Task Scheduling (Cron-like scheduler)  
- Event System (Application events)  

### 🟢 Nice-to-Have
- API Resources (Enhanced transformers)  
- Real-time Features (WebSocket support)  
- Admin Panel (Auto-generated admin)  

---

## 💻 Quick Start for Contributors

### 1️⃣ Setup Development Environment
```bash
# Clone and install
git clone https://github.com/shuvodewan/Axiom-php-web-framwork.git
cd Axiom-php-web-framwork

composer install
yarn install

# Configure environment
cp .env.example .env
# Edit .env with your settings
```

### 2️⃣ Explore the Codebase
```bash
# See all available commands
php axiom

# Generate a test module
php axiom app:create TestModule

# Check the structure
tree app/TestModule/
```

### 3️⃣ Run the Framework
```bash
# Start development server
php axiom project:start

# Build frontend assets
yarn dev

# Visit http://localhost:8000
```

---

## 🎯 Good First Issues

If you're new to the project, try these:

- Add new **validation rules**
- Create new **form fields**
- Add **Twig template filters**
- Write **documentation and examples**
- Build **example modules**

---

## 🏗️ Project Structure Deep Dive
```
axiom-framework/
├── app/
│   ├── Authentication/
│   │   ├── Controllers/
│   │   │   ├── RoleController.php
│   │   │   └── UserController.php
│   │   ├── Entities/
│   │   │   ├── Module.php
│   │   │   ├── Permission.php
│   │   │   ├── Role.php
│   │   │   └── User.php
│   │   ├── Seeders/
│   │   │   ├── PermissionSeeder.php
│   │   │   ├── RoleSeeder.php
│   │   │   └── UserSeeder.php
│   │   ├── Services/
│   │   │   ├── RoleService.php
│   │   │   └── UserService.php
│   │   ├── Transports/
│   │   │   ├── Handlers/
│   │   │   │   └── MailHandler.php
│   │   │   ├── Jobs/
│   │   │   │   └── MailJob.php
│   │   │   └── Mails/
│   │   │       └── PasswordResetMail.php
│   │   └── AuthenticationApp.php
│   ├── Axiom/
│   │   ├── Controllers/
│   │   │   └── AxiomController.php
│   │   ├── Entities/
│   │   │   └── Menue.php
│   │   ├── Services/
│   │   │   └── AxiomService.php
│   │   ├── Transformers/
│   │   │   ├── RoleTransformer.php
│   │   │   └── TestTransformer.php
│   │   └── AxiomApp.php
│   ├── Dashboard/
│   │   ├── Controllers/
│   │   │   └── DashboardController.php
│   │   ├── Services/
│   │   │   └── DashboardService.php
│   │   └── DashboardApp.php
│   └── Test/
│       ├── Controllers/
│       │   └── TestController.php
│       ├── Entities/
│       │   └── Test.php
│       ├── Services/
│       │   └── TestService.php
│       └── TestApp.php
├── config/
│   ├── app.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystem.php
│   ├── log.php
│   ├── mail.php
│   ├── messenger.php
│   ├── session.php
│   └── vite.php
├── database/
│   ├── Migrations/
│   └── Seeders/
│       ├── DatabaseSeeder.php
│       └── RoleSeeder.php
├── project/
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Middlewares/
│   │   ├── AuthMiddleware.php
│   │   ├── CsrfProtectionMiddleware.php
│   │   ├── GuestMiddleware.php
│   │   ├── Register.php
│   │   └── StartSessionMiddleware.php
│   ├── route/
│   │   └── web.php
│   ├── templates/
│   │   ├── assets/
│   │   │   ├── css/
│   │   │   │   ├── admin.css
│   │   │   │   └── app.css
│   │   │   └── js/
│   │   │       ├── admin.js
│   │   │       └── app.js
│   │   ├── backend/
│   │   │   ├── dashboard.twig
│   │   │   ├── index.twig
│   │   │   └── intruduction.twig
│   │   ├── errors/
│   │   │   └── debug.twig
│   │   ├── frontend/
│   │   │   ├── docs/
│   │   │   │   └── v1/
│   │   │   │       └── intruduction.twig
│   │   │   ├── documentation.twig
│   │   │   └── home.twig
│   │   ├── layouts/
│   │   │   ├── backend/
│   │   │   │   ├── partials/
│   │   │   │   │   ├── footer.twig
│   │   │   │   │   ├── sidebar.twig
│   │   │   │   │   └── topbar.twig
│   │   │   │   └── app.twig
│   │   │   └── frontend/
│   │   │       ├── partials/
│   │   │       │   ├── docheader.twig
│   │   │       │   ├── footer.twig
│   │   │       │   ├── header.twig
│   │   │       │   └── sidebar.twig
│   │   │       ├── app.twig
│   │   │       └── documentation.twig
│   │   └── mails/
│   │       └── forgetPassword.twig
│   └── Registry.php
├── public/
│   ├── build/
│   ├── index.php
├── src/
│   ├── Application/
│   │   ├── Actions/
│   │   │   └── RegisterRoutes.php
│   │   ├── Base/
│   │   │   ├── Controller.php
│   │   │   └── Service.php
│   │   ├── Commands/
│   │   │   ├── AppGeneratorCommand.php
│   │   │   ├── ControllerGeneratorCommand.php
│   │   │   ├── CreateApplicationCommand.php
│   │   │   ├── DeleteApplicationCommand.php
│   │   │   ├── EntityGeneratorCommand.php
│   │   │   ├── EntityHelpCommand.php
│   │   │   ├── SeederGeneratorCommand.php
│   │   │   ├── ServiceGeneratorCommand.php
│   │   │   └── TransformersGeneratorCommand.php
│   │   ├── Stubs/
│   │   │   ├── App.stub
│   │   │   ├── Controller.stub
│   │   │   ├── Entity.stub
│   │   │   ├── Seeder.stub
│   │   │   ├── Service.stub
│   │   │   └── Transformer.stub
│   │   ├── App.php
│   │   ├── ApplicationGeneratorTrait.php
│   │   ├── AppManager.php
│   │   ├── MiddlewareRegistry.php
│   │   └── ProjectRegistry.php
│   ├── Cache/
│   │   ├── Cache.php
│   │   ├── CacheContract.php
│   │   ├── CacheTrait.php
│   │   ├── FileDriver.php
│   │   └── RedisDriver.php
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── AppCashClearCommand.php
│   │   │   └── AppServeCommand.php
│   │   ├── Command.php
│   │   ├── Kernel.php
│   │   └── Preview.php
│   ├── Core/
│   │   ├── Attribute/
│   │   │   ├── Delete.php
│   │   │   ├── Get.php
│   │   │   ├── Group.php
│   │   │   ├── Patch.php
│   │   │   ├── Post.php
│   │   │   ├── Put.php
│   │   │   └── Route.php
│   │   ├── Enum/
│   │   │   └── RouteEnum.php
│   │   ├── Application.php
│   │   ├── Config.php
│   │   ├── Container.php
│   │   ├── EnvironmentTrait.php
│   │   ├── Log.php
│   │   └── ServiceProxy.php
│   ├── Database/
│   │   ├── Commands/
│   │   │   ├── DiffCommand.php
│   │   │   ├── ExecuteMigrationCommand.php
│   │   │   ├── GenerateMigrationCommand.php
│   │   │   ├── LatestCommand.php
│   │   │   ├── ListCommand.php
│   │   │   ├── ListSeederCommand.php
│   │   │   ├── MakeSeederCommand.php
│   │   │   ├── MigrateCommand.php
│   │   │   ├── MigrationCommand.php
│   │   │   ├── PopulateSeeder.php
│   │   │   ├── RollbackCommand.php
│   │   │   ├── StatusCommand.php
│   │   │   ├── SyncMetadataCommand.php
│   │   │   └── VersionCommand.php
│   │   ├── Relations/
│   │   │   ├── BelongsTo.php
│   │   │   ├── BelongsToMany.php
│   │   │   ├── HasMany.php
│   │   │   ├── HasOne.php
│   │   │   ├── Relation.php
│   │   │   └── RelationShipMethodTrait.php
│   │   ├── Stubs/
│   │   │   └── Seeder.stub
│   │   ├── Builder.php
│   │   ├── DatabaseManager.php
│   │   ├── DB.php
│   │   ├── DoctrineRegistry.php
│   │   ├── Entity.php
│   │   ├── Paginator.php
│   │   ├── PostGenerateSchemaListener.php
│   │   └── Seeder.php
│   ├── Exception/
│   │   ├── Exceptions/
│   │   │   ├── FileNotFoundException.php
│   │   │   └── FilesystemException.php
│   │   ├── templates/
│   │   │   ├── 400.php
│   │   │   ├── 404.php
│   │   │   ├── 500.php
│   │   │   ├── layout.php
│   │   │   └── style.css
│   │   ├── ExceptionHandlerInterface.php
│   │   ├── Handler.php
│   │   └── WhoopsHandler.php
│   ├── Facade/
│   │   ├── Arr.php
│   │   ├── Cache.php
│   │   ├── Config.php
│   │   ├── Crypt.php
│   │   ├── DB.php
│   │   ├── Faker.php
│   │   ├── Filesystem.php
│   │   ├── Hash.php
│   │   ├── Log.php
│   │   ├── Mail.php
│   │   ├── Messenger.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Storage.php
│   │   ├── Str.php
│   │   ├── Url.php
│   │   └── Vite.php
│   ├── Filesystem/
│   │   ├── FileManager.php
│   │   ├── Filesystem.php
│   │   ├── FileSystemDriverContract.php
│   │   ├── LocalDriver.php
│   │   ├── S3Driver.php
│   │   └── Upload.php
│   ├── Helpers/
│   │   ├── core.php
│   │   ├── helper.php
│   │   └── path.php
│   ├── Http/
│   │   ├── Commands/
│   │   │   └── RouteListCommand.php
│   │   ├── DataTransformerTrait.php
│   │   ├── FileTrait.php
│   │   ├── MiddlewareContract.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── ResponseTrait.php
│   │   ├── Route.php
│   │   ├── Router.php
│   │   ├── Session.php
│   │   ├── Transformer.php
│   │   ├── Validator.php
│   │   └── ValidatorRules.php
│   ├── Mail/
│   │   ├── Contracts/
│   │   │   └── Transport.php
│   │   ├── Transports/
│   │   │   ├── MailgunTransport.php
│   │   │   ├── PostmarkTransport.php
│   │   │   ├── SendmailTransport.php
│   │   │   └── SmtpTransport.php
│   │   ├── Mailable.php
│   │   ├── MailManager.php
│   │   └── MailService.php
│   ├── Messenger/
│   │   ├── Commands/
│   │   │   ├── FaildJobList.php
│   │   │   └── WorkerCommand.php
│   │   ├── HandlerContract.php
│   │   ├── MessageManager.php
│   │   ├── QueueWorker.php
│   │   ├── RetryStrategy.php
│   │   ├── TransportFactoryLocator.php
│   │   └── TransportManager.php
│   ├── Support/
│   │   ├── Arr.php
│   │   ├── Crypt.php
│   │   ├── DD.php
│   │   ├── Faker.php
│   │   ├── Hash.php
│   │   ├── Str.php
│   │   ├── Url.php
│   │   └── Vite.php
│   ├── Templating/
│   │   ├── Form/
│   │   │   ├── Fields/
│   │   │   │   ├── CheckboxField.php
│   │   │   │   ├── ColorField.php
│   │   │   │   ├── DateField.php
│   │   │   │   ├── DateTimeField.php
│   │   │   │   ├── EmailField.php
│   │   │   │   ├── FileField.php
│   │   │   │   ├── HiddenField.php
│   │   │   │   ├── InputField.php
│   │   │   │   ├── NumberField.php
│   │   │   │   ├── PasswordField.php
│   │   │   │   ├── RadioField.php
│   │   │   │   ├── RangeField.php
│   │   │   │   ├── SelectField.php
│   │   │   │   ├── TextAreaField.php
│   │   │   │   └── TextField.php
│   │   │   ├── Themes/
│   │   │   │   ├── BootStrapTheme.php
│   │   │   │   └── TailwindTheme.php
│   │   │   ├── BaseField.php
│   │   │   ├── FormBuilder.php
│   │   │   └── ThemeContract.php
│   │   └── Table/
│   │       ├── Filters/
│   │       │   ├── BooleanFilter.php
│   │       │   ├── DateFilter.php
│   │       │   ├── DateRangeFilter.php
│   │       │   ├── Filter.php
│   │       │   ├── NumberFilter.php
│   │       │   ├── SelectFilter.php
│   │       │   └── TextFilter.php
│   │       ├── Themes/
│   │       │   ├── AxiomTable.js
│   │       │   ├── BootStrapTheme.php
│   │       │   └── TailwindTheme.php
│   │       ├── Action.php
│   │       ├── BulkAction.php
│   │       ├── Column.php
│   │       ├── Export.php
│   │       ├── TableBuilder.php
│   │       └── ThemeContract.php
│   ├── Traits/
│   │   └── InstanceTrait.php
│   └── Views/
│       ├── CoreView.php
│       ├── TwigDriver.php
│       ├── TwigExtension.php
│       ├── TwigFilters.php
│       ├── TwigMethods.php
│       ├── View.php
│       └── ViewDriverContract.php
├── storage/
│   ├── app/
│   ├── cache/
│   ├── doctrine/
│   └── logs/
├── axiom
├── composer.json
├── package.json
├── postcss.config.cjs
├── README.md
├── tailwind.config.js
├── tree_generator.php
├── vite.config.js
```

---

## 🔧 Core Components Overview

### 🧱 Entity System (Hybrid ORM)
```php
<?php
namespace App\Blog\Entities;

use Axiom\Database\Entity;

class Post extends Entity
{
    #[Id, GeneratedValue, Column]
    protected int $id;
    
    #[Column]
    protected string $title;

    // Active Record convenience
    public static function published(): array
    {
        return static::where('status', 'published')->get();
    }

    // Relationships
    public function author(): User
    {
        return $this->relation('author');
    }
}
```

### ⚙️ Service Layer Architecture
```php
<?php
namespace App\Blog\Services;

use Axiom\Application\Base\Service;
use App\Blog\Entities\Post;

class PostService extends Service
{
    protected $entity = Post::class;
    
    public function createWithTags(array $data, array $tags): Post
    {
        $post = Post::create($data);
        $post->tags()->sync($tags);
        return $post;
    }
}
```

---

## 🤝 How to Contribute

### For New Maintainers
1. Fork the repository  
2. Set up your development environment  
3. Pick a high-priority issue  
4. Submit PRs with tests and documentation  
5. Join discussions on framework direction  

### Contribution Areas Needed
- **Core Framework:** PHP architecture  
- **Frontend:** JavaScript, CSS, build tools  
- **Documentation:** Guides, tutorials  
- **Testing:** PHPUnit, frontend tests  
- **Community:** Support, ecosystem development  

### Development Guidelines
- Follow **PSR standards**  
- Write **comprehensive tests**  
- Update **documentation**  
- Use **semantic versioning**  
- Be **welcoming** to new contributors  

---

## 📚 Learning Resources

- Explore the `src/` directory (framework core)
- Check `app/Authentication/` for module structure
- Review CLI commands in `src/Console/Commands/`
- Study `src/Database/Entity.php` for ORM internals

### Related Technologies
- [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html)
- [Twig Templating](https://twig.symfony.com/)
- [Laravel Concepts](https://laravel.com/docs)
- [Django Apps System](https://docs.djangoproject.com/en/stable/)

---

## 🏆 Why Contribute to Axiom?

### For Your Career
- Lead an open-source project  
- Deepen your PHP framework knowledge  
- Build modern full-stack skills  
- Gain architecture design experience  

### For the Community
- Create an alternative to monolithic frameworks  
- Blend the best of Laravel and Django  
- Empower developers with a new PHP ecosystem  

---

## 📊 Project Roadmap

### **Phase 1: Core Completion**
- ✅ Complete authentication system  
- ✅ Implement authorization  
- ✅ Finish queue system  
- 🚀 Release v1.0.0  

### **Phase 2: Ecosystem**
- Package system  
- Admin panel generator  
- API documentation  
- Testing suite  

### **Phase 3: Innovation**
- Real-time features  
- Microservices support  
- GraphQL integration  
- Deployment tools  

---

## ❓ Frequently Asked Questions

**Q:** How stable is Axiom currently?  
**A:** The foundation is stable. Core systems like ORM, CLI, and modular architecture are complete. Missing pieces include auth and queues.

**Q:** What's the learning curve?  
**A:** If you know Laravel or Django, you’ll feel right at home.

**Q:** Can I use this for production?  
**A:** Not yet for mission-critical apps, but ideal for side projects during core completion.

**Q:** How can I help if I’m new?  
**A:** Contribute to documentation, testing, and example applications — the codebase is clean and beginner-friendly.

---

## 📞 Get Involved

### Communication Channels
- **GitHub Issues** – Bug reports and feature requests  
- **GitHub Discussions** – Ideas and planning  
- **Pull Requests** – Code contributions  

### Current Needs
- Lead Maintainers 🧭  
- Core Developers 💻  
- Documentation Writers 📝  
- Testers 🧪  

---

## 📄 License

Axiom Framework is open-sourced under the **MIT License**.  
See the [LICENSE](LICENSE) file for details.

---

## 🎉 Join the Axiom Community!

The architecture is solid. The foundation is complete. The **vision is clear**.  
What’s missing is **you**.

Whether you want to:

- Lead an open-source project  
- Learn modern PHP framework development  
- Build something impactful for the PHP community  
- Create the next great web framework  

👉 **Start by forking the repo, exploring the codebase, and opening an issue to introduce yourself!**

> “Great frameworks aren’t built by individuals — they’re grown by communities.”
