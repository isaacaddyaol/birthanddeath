# Entity Relationship Diagram - Birth and Death Registration System

## Database Schema Overview
The Birth and Death Registration System uses a MySQL database with the following entities and relationships.

## Entities

### 1. tbladmin (Administrators)
**Primary Key:** adminId (INT, AUTO_INCREMENT)
**Attributes:**
- email (VARCHAR(255)) - Administrator's email address
- username (VARCHAR(50)) - Login username
- password (VARCHAR(20)) - Encrypted password
- role (VARCHAR(50)) - User role (Super Administrator, Administrator)
- RegCentre (BIGINT(10)) - Foreign key to registration center
- dateReg (DATE) - Registration date

**Constraints:**
- email must be unique
- username must be unique
- RegCentre references tblcentre.centreId

### 2. tblcentre (Registration Centers)
**Primary Key:** centreId (INT, AUTO_INCREMENT)
**Attributes:**
- centreName (VARCHAR(255)) - Name of the registration center
- state (VARCHAR(255)) - State where center is located
- lga (VARCHAR(255)) - Local Government Area
- dateReg (DATE) - Center registration date

**Constraints:**
- centreName must be unique within state

### 3. tblbirth (Birth Registrations)
**Primary Key:** birthId (INT, AUTO_INCREMENT)
**Attributes:**
- certNo (VARCHAR(255)) - Unique certificate number
- firstName (VARCHAR(255)) - Child's first name
- lastName (VARCHAR(255)) - Child's last name
- fathersName (VARCHAR(255)) - Father's full name
- mothersName (VARCHAR(255)) - Mother's full name
- gender (VARCHAR(10)) - Child's gender (Male/Female)
- genotype (VARCHAR(10)) - Blood genotype (AA, AS, SS, etc.)
- weight (VARCHAR(255)) - Birth weight
- birthPlace (VARCHAR(255)) - Place of birth
- pod (VARCHAR(255)) - Place of delivery (hospital, home, etc.)
- state (VARCHAR(255)) - State of birth
- lga (VARCHAR(255)) - Local Government Area
- dateOfBirth (DATE) - Date of birth
- yearOfBirth (DATE) - Year of birth
- PlaceOfIssue (VARCHAR(255)) - Place where certificate is issued
- regCentre (VARCHAR(255)) - Registration center name
- dateReg (DATE) - Registration date
- father_occupation (VARCHAR(255)) - Father's occupation
- father_nationality (VARCHAR(255)) - Father's nationality
- father_religion (VARCHAR(255)) - Father's religion
- mother_nationality (VARCHAR(255)) - Mother's nationality
- payId (INT) - Payment status (0=unpaid, 1=paid)

**Constraints:**
- certNo must be unique
- dateOfBirth cannot be in the future
- gender must be 'Male' or 'Female'

### 4. tbldeath (Death Registrations)
**Primary Key:** deathId (INT, AUTO_INCREMENT)
**Attributes:**
- certNo (VARCHAR(255)) - Unique certificate number
- firstName (VARCHAR(255)) - Deceased's first name
- lastName (VARCHAR(255)) - Deceased's last name
- gender (VARCHAR(10)) - Deceased's gender
- state (VARCHAR(255)) - State of death
- lga (VARCHAR(255)) - Local Government Area
- address (VARCHAR(255)) - Address of deceased
- ageAtDeath (INT(10)) - Age at time of death
- placeOfDeath (VARCHAR(255)) - Place where death occurred
- dateOfDeath (DATE) - Date of death
- PlaceOfIssue (VARCHAR(255)) - Place where certificate is issued
- regCentre (VARCHAR(255)) - Registration center name
- dateReg (DATE) - Registration date
- cause_death (VARCHAR(255)) - Cause of death
- payId (INT) - Payment status (0=unpaid, 1=paid)

**Constraints:**
- certNo must be unique
- dateOfDeath cannot be in the future
- ageAtDeath must be positive
- gender must be 'Male' or 'Female'

### 5. tblcertno (Certificate Number Management)
**Primary Key:** Id (INT, AUTO_INCREMENT)
**Attributes:**
- certId (VARCHAR(20)) - Certificate type identifier
- lastCertId (VARCHAR(20)) - Last issued certificate number

**Constraints:**
- certId must be unique
- Used for auto-generating certificate numbers

## Relationships

### 1. Administrator to Registration Center (Many-to-One)
- **Relationship:** An administrator belongs to one registration center
- **Cardinality:** Many administrators can work at one center
- **Foreign Key:** tbladmin.RegCentre → tblcentre.centreId
- **Business Rule:** Each administrator is assigned to exactly one center

### 2. Birth Registration to Registration Center (Many-to-One)
- **Relationship:** Birth registrations are processed at registration centers
- **Cardinality:** Many birth registrations can be processed at one center
- **Foreign Key:** tblbirth.regCentre → tblcentre.centreName (string-based relationship)
- **Business Rule:** Each birth registration must be associated with a center

### 3. Death Registration to Registration Center (Many-to-One)
- **Relationship:** Death registrations are processed at registration centers
- **Cardinality:** Many death registrations can be processed at one center
- **Foreign Key:** tbldeath.regCentre → tblcentre.centreName (string-based relationship)
- **Business Rule:** Each death registration must be associated with a center

### 4. Certificate Numbers (One-to-Many)
- **Relationship:** Certificate number management for different types
- **Cardinality:** One certificate type can have many issued numbers
- **Business Rule:** Birth certificates use certId '100000', Death certificates use '200000'

## Data Integrity Constraints

### Primary Key Constraints
- All entities have auto-incrementing primary keys
- Primary keys are unique and non-null

### Foreign Key Constraints
- tbladmin.RegCentre references tblcentre.centreId
- Registration center names in birth/death tables should match center names

### Unique Constraints
- Certificate numbers must be unique across the system
- Email addresses must be unique for administrators
- Usernames must be unique for administrators
- Center names should be unique within states

### Check Constraints
- Gender values must be 'Male' or 'Female'
- Dates cannot be in the future
- Age at death must be positive
- Payment status must be 0 or 1

## Indexes

### Primary Indexes
- adminId (tbladmin)
- centreId (tblcentre)
- birthId (tblbirth)
- deathId (tbldeath)
- Id (tblcertno)

### Secondary Indexes
- email (tbladmin) - for login queries
- username (tbladmin) - for login queries
- certNo (tblbirth) - for certificate lookups
- certNo (tbldeath) - for certificate lookups
- dateReg (tblbirth) - for reporting
- dateReg (tbldeath) - for reporting
- RegCentre (tbladmin) - for center-based queries

## Data Flow

### Registration Process
1. Administrator logs in (tbladmin)
2. Creates birth/death registration (tblbirth/tbldeath)
3. System generates certificate number (tblcertno)
4. Payment is processed (payId updated)
5. Certificate is generated and printed

### Reporting Process
1. System queries registrations by date range
2. Filters by registration center
3. Generates statistics and reports
4. Exports data for analysis

## Security Considerations

### Authentication
- Passwords are stored (should be hashed in production)
- Session management for logged-in users
- Role-based access control

### Data Protection
- Sensitive personal information stored
- Access limited by user roles
- Center-based data isolation

## Performance Considerations

### Query Optimization
- Indexes on frequently queried fields
- Efficient date range queries
- Center-based data partitioning

### Scalability
- Auto-incrementing IDs for growth
- Separate tables for different entity types
- Efficient certificate number generation 