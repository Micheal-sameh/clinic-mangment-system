# Clinic Management System

## Project Overview

The Clinic Management System is a web-based application built using Laravel, designed to streamline the operations of a medical clinic. It facilitates the management of users (patients, staff), medical procedures, reservations, working days, and system settings. The system incorporates role-based access control (RBAC) using Spatie Laravel Permission package, ensuring that different user types have appropriate permissions to perform their duties. It supports multilingual features (English and Arabic) and includes features like reservation scheduling, procedure management, reporting, and media handling for settings.

The application is containerized using Docker for easy deployment and includes seeders for initial data setup. It uses Sanctum for API authentication and provides a RESTful API for frontend interactions.

## Roles and Permissions

The system defines three primary roles: Admin, Secretary, and Patient (referred to as User in some contexts). Each role has specific permissions to access and manipulate data, ensuring security and operational efficiency.

### Admin Capabilities

The Admin has full administrative control over the system, including:

- **User Management**: List, create, edit, view, delete users (patients and staff), reset passwords, and manage user profiles.
- **Procedure Management**: Full CRUD (Create, Read, Update, Delete) operations on medical procedures, including names, descriptions, and prices.
- **Reservation Management**: Complete control over reservations, including listing, creating, editing, viewing, deleting, applying reservations, marking as paid, viewing history, and managing reservation notes.
- **Working Days Management**: List and create working days for the clinic, defining operational hours per day.
- **Reports**: Access to generate and view reports on clinic activities.
- **Settings**: Update system settings, such as uploading logos or configuring other parameters.
- **Patient List**: View the list of patients.

Admins can oversee all aspects of the clinic's operations, make system-wide changes, and ensure compliance with policies.

### Secretary Capabilities

The Secretary role is focused on operational support, managing day-to-day clinic activities:

- **User Profile**: Manage their own profile.
- **Patient Management**: View the list of patients and create new users (likely patients).
- **Procedure Management**: List and view procedures (read-only access).
- **Reservation Management**: Full CRUD operations on reservations, including adding procedures to reservations, editing, viewing, deleting, marking as paid, and viewing reservation history.
- **Working Days Management**: List working days (read-only access).

Secretaries handle patient interactions, schedule reservations, and assist in maintaining clinic workflows without full administrative privileges.

### User (Patient) Capabilities

Patients (Users) have limited access focused on their personal interactions with the clinic:

- **User Profile**: Manage their own profile.
- **Reservation Management**: Create, edit, view, delete their own reservations, and view reservation history.
- **Working Days Management**: List working days to understand clinic availability.

Patients can book appointments, manage their schedules, and view necessary information without accessing sensitive data.

## Benefits of the System

The Clinic Management System offers numerous benefits to improve clinic operations, patient experience, and overall efficiency:

- **Streamlined Operations**: Automates reservation scheduling, reducing manual errors and conflicts in appointments.
- **Role-Based Security**: Ensures data integrity and privacy by restricting access based on user roles, preventing unauthorized actions.
- **Multilingual Support**: Supports English and Arabic, making it accessible to diverse users.
- **Scalability**: Built on Laravel, it can handle growing clinic needs with modular architecture (repositories, services, DTOs).
- **Reporting and Analytics**: Provides reports for admins to analyze clinic performance, revenue, and patient trends.
- **Media Management**: Allows uploading and managing media files (e.g., logos) for branding and settings.
- **API-Driven**: Enables integration with other systems or mobile apps via RESTful APIs.
- **Docker Deployment**: Simplifies deployment and scaling in various environments.
- **Patient Empowerment**: Allows patients to self-manage reservations, improving convenience and satisfaction.
- **Efficiency Gains**: Reduces administrative workload for secretaries and admins through automated processes like reservation numbering and time slot management.
- **Data Consistency**: Uses Eloquent ORM and migrations to maintain database integrity and relationships.
- **Customization**: Supports settings for clinic-specific configurations, adapting to different operational needs.

This system enhances productivity, reduces costs, and improves patient care by digitizing and optimizing clinic management processes.
