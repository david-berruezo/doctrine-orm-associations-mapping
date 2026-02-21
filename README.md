# Doctrine ORM - Associations Mapping

Practical examples of **Doctrine ORM association mapping** in PHP. This repository demonstrates the different types of entity relationships (One-To-One, One-To-Many, Many-To-One, Many-To-Many) using Doctrine annotations, providing clear and reusable code patterns for real-world projects.
---

## Table of Contents

- [About](#about)
- [Association Types](#association-types)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Resources](#resources)
- [Author](#author)

---

## About

When working with Doctrine ORM, understanding how to properly map associations between entities is essential. This project serves as a reference and learning resource, providing standalone examples of each association type with clear annotations and configuration.

Instead of working with foreign keys directly in your code, Doctrine lets you work with object references and converts them to foreign keys internally. This repository shows how to implement that correctly.

---

## Association Types

The following association mappings are covered in this project:

| Association | Description | Example |
|---|---|---|
| **Many-To-One** | Many entities reference one entity | Many `Articles` belong to one `Category` |
| **One-To-Many** | One entity has many related entities | One `Category` has many `Articles` |
| **One-To-One** | One entity references exactly one entity | One `User` has one `Profile` |
| **Many-To-Many** | Multiple entities reference multiple entities | Many `Users` belong to many `Groups` |

Each example includes both **unidirectional** and **bidirectional** variants where applicable, explaining the concept of **owning side** and **inverse side**.

---

## Project Structure

```
doctrine-orm-associations-mapping/
├── src/                    # Entity classes with Doctrine annotations
├── helpers/                # Helper utilities and functions
├── bootstrap.php           # Doctrine EntityManager configuration
├── cli-config.php          # Doctrine CLI configuration
├── composer.json           # Dependencies (doctrine/orm, etc.)
├── index.php               # Entry point / examples execution
└── README.md
```

---

## Requirements

- **PHP** >= 8.0
- **Composer**
- **MySQL** / MariaDB (or any Doctrine-supported database)

---

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/david-berruezo/doctrine-orm-associations-mapping.git
cd doctrine-orm-associations-mapping
```

2. **Install dependencies**

```bash
composer install
```

3. **Configure your database connection**

Edit the `bootstrap.php` file and update the database parameters (dbname, user, password, host) to match your local environment.

---

## Database Setup

Once the database connection is configured, use the Doctrine CLI tool to generate the schema from your entity mappings:

```bash
# Create or update the database schema
vendor/bin/doctrine orm:schema-tool:update --force
```

You can also validate that your mappings are correct:

```bash
# Validate entity mappings
vendor/bin/doctrine orm:validate-schema
```

Other useful Doctrine CLI commands:

```bash
# View the SQL that would be executed (dry run)
vendor/bin/doctrine orm:schema-tool:update --dump-sql

# Drop the entire schema (use with caution)
vendor/bin/doctrine orm:schema-tool:drop --force

# Get information about a specific entity
vendor/bin/doctrine orm:info
```

---

## Usage

After setting up the database, you can run the examples:

```bash
php index.php
```

This will execute the association mapping examples, creating entities and persisting the relationships to the database.

---

## Resources

Official documentation and references used in this project:

- [Doctrine ORM - Association Mapping](https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/association-mapping.html)
- [Doctrine ORM - Working with Associations](https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/working-with-associations.html)
- [Doctrine ORM - Getting Started](https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html)
- [Symfony - How to Work with Doctrine Associations](https://symfony.com/doc/current/doctrine/associations.html)

---

## Author

**David Berruezo** - Software Engineer | Fullstack Developer

- GitHub: [@david-berruezo](https://github.com/david-berruezo)
- Website: [davidberruezo.com](https://www.davidberruezo.com)
