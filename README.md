# KATA TEST

This project is to refactor the original KATA TEST, `TemplateManager` which build a template to send the users arguments like "username", "destination"...

Refactoring work
- 
- Separating responsibilities by breaking the code to difference services which handles a specific data decorating `QuoteTextDecorator` & `UserTextDecorator` so any new content decorating will only need to implement the interface `TextDecoratorInterface`.
- Using namespaces by using PS4 autoloader
- Cleaning Entities so they can be Repositories specific and hold no business logic (Database specific), in my case removed rendering methods from Quote Entity.
- Use the new decorators in the Template Manager service and improve the code readability without changing the method signature.

Future ideas and improvements
-
- Use clean architecture to better organise the code and introduce `Infrastructure`, `Application` & `Domain` Layers.
- Implement integration tests
- Introduce strict typing (scalar types for PHP 7) and upgrading PHP version to 8+
- Translation for content in templates (more a product feature)
- Extend the solution to support other text decorators for other entities `Destinitation` ...

## ✅ Requirements

- PHP 5.5.9 or higher (compatible with PHP 7)
- Composer

## 📦 Installation

1. **Clone the project**
```bash
git clone https://github.com/sihamlabssir/KataTest.git
```

2. **Install dependencies**
```bash
composer install
```

3. **Generate the autoloader**
```bash
composer dump-autoload
```

4. **Run the application**
```bash
php -S localhost:8080 -t example
```
5. **Test**
```bash
http://localhost:8080/example.php
```
