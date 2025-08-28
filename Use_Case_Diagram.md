# Use Case Diagram - Birth and Death Registration System

## System Overview
The Birth and Death Registration System is a web-based application for managing birth and death registrations, certificate generation, and administrative functions for registration centers.

## Actors

### Primary Actors
1. **Super Administrator** - Has full system access and can manage all aspects
2. **Administrator** - Manages registrations and certificates for their assigned center
3. **Registration Center Staff** - Handles daily registration operations

### Secondary Actors
4. **Payment Gateway (Paystack)** - Processes certificate payments
5. **Database System** - Stores all registration data
6. **Certificate Printer** - Generates official certificates

## Use Cases

### Authentication & User Management
- **Login to System**
  - Actors: Super Administrator, Administrator
  - Description: Users authenticate with username/email and password
  - Preconditions: User has valid credentials
  - Postconditions: User is logged in and redirected to dashboard

- **Manage Users**
  - Actors: Super Administrator
  - Description: Create, edit, and delete user accounts
  - Includes: Create User, Edit User, Delete User, View User Reports

### Registration Management
- **Register Birth**
  - Actors: Administrator, Registration Center Staff
  - Description: Record new birth registration with all required details
  - Includes: Validate Birth Data, Generate Certificate Number
  - Extends: Print Birth Certificate (after payment)

- **Register Death**
  - Actors: Administrator, Registration Center Staff
  - Description: Record new death registration with all required details
  - Includes: Validate Death Data, Generate Certificate Number
  - Extends: Print Death Certificate (after payment)

- **Edit Registration**
  - Actors: Administrator, Registration Center Staff
  - Description: Modify existing birth or death registration details
  - Includes: Validate Updated Data

- **Delete Registration**
  - Actors: Administrator, Registration Center Staff
  - Description: Remove birth or death registration from system
  - Includes: Confirm Deletion

### Certificate Management
- **Generate Birth Certificate**
  - Actors: Administrator, Registration Center Staff
  - Description: Create official birth certificate document
  - Preconditions: Birth registration exists and payment is completed
  - Includes: Format Certificate, Print Certificate

- **Generate Death Certificate**
  - Actors: Administrator, Registration Center Staff
  - Description: Create official death certificate document
  - Preconditions: Death registration exists and payment is completed
  - Includes: Format Certificate, Print Certificate

- **Print Certificate**
  - Actors: Administrator, Registration Center Staff
  - Description: Print physical copy of certificate
  - Includes: Certificate Printer

### Payment Processing
- **Process Certificate Payment**
  - Actors: Administrator, Registration Center Staff
  - Description: Handle payment for certificate generation
  - Includes: Payment Gateway (Paystack)
  - Extends: Generate Certificate (after successful payment)

### Reporting & Analytics
- **View Birth Reports**
  - Actors: Super Administrator, Administrator
  - Description: Access comprehensive birth registration reports
  - Includes: Filter Reports, Export Data

- **View Death Reports**
  - Actors: Super Administrator, Administrator
  - Description: Access comprehensive death registration reports
  - Includes: Filter Reports, Export Data

- **View Center Reports**
  - Actors: Super Administrator
  - Description: Monitor performance of all registration centers
  - Includes: Performance Metrics, Statistics

- **View User Reports**
  - Actors: Super Administrator
  - Description: Monitor user activity and system usage
  - Includes: User Activity Logs, Access Reports

### Center Management
- **Manage Registration Centers**
  - Actors: Super Administrator
  - Description: Create and manage registration centers
  - Includes: Create Center, Edit Center, Delete Center

### Dashboard & Monitoring
- **View Dashboard**
  - Actors: Super Administrator, Administrator
  - Description: Access system overview with key metrics
  - Includes: Performance Metrics, Recent Activities

- **Monitor System Performance**
  - Actors: Super Administrator
  - Description: Track system usage and performance indicators
  - Includes: Monthly Statistics, Growth Analysis

## Use Case Relationships

### Include Relationships
- Login to System includes Validate Credentials
- Register Birth includes Validate Birth Data
- Register Death includes Validate Death Data
- Generate Certificate includes Format Certificate
- Print Certificate includes Certificate Printer

### Extend Relationships
- Generate Birth Certificate extends Register Birth (after payment)
- Generate Death Certificate extends Register Death (after payment)
- Process Certificate Payment extends Generate Certificate

### Generalization Relationships
- Super Administrator is a specialized Administrator
- Administrator is a specialized Registration Center Staff

## System Boundaries

### Internal System
- User Authentication
- Registration Management
- Certificate Generation
- Reporting System
- Dashboard Analytics

### External Systems
- Payment Gateway (Paystack)
- Database System
- Certificate Printer
- Email System (for notifications)

## Business Rules
1. Only Super Administrators can manage users and centers
2. Administrators can only access data for their assigned center
3. Certificate generation requires successful payment
4. All registrations must have unique certificate numbers
5. Users must be authenticated to access any system function
6. Registration data cannot be modified after certificate generation 