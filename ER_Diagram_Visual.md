# Visual ER Diagram - Birth and Death Registration System

## Entity Relationship Diagram (ASCII Representation)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           BIRTH AND DEATH REGISTRATION SYSTEM                   │
│                              DATABASE SCHEMA                                    │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                ENTITIES                                         │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────┐
│ 1. tbladmin (Administrators)                                                    │
├─────────────────────────────────────────────────────────────────────────────────┤
│ adminId (PK) │ email │ username │ password │ role │ RegCentre (FK) │ dateReg   │
│ INT AI       │ VARCHAR│ VARCHAR │ VARCHAR  │ VARCHAR│ BIGINT        │ DATE      │
│              │ (255)  │ (50)    │ (20)     │ (50)   │               │           │
└─────────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    │ (Many-to-One)
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│ 2. tblcentre (Registration Centers)                                             │
├─────────────────────────────────────────────────────────────────────────────────┤
│ centreId (PK) │ centreName │ state │ lga │ dateReg                             │
│ INT AI        │ VARCHAR    │ VARCHAR│ VARCHAR│ DATE                            │
│               │ (255)      │ (255) │ (255) │                                   │
└─────────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    │ (One-to-Many)
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│ 3. tblbirth (Birth Registrations)                                               │
├─────────────────────────────────────────────────────────────────────────────────┤
│ birthId (PK) │ certNo │ firstName │ lastName │ fathersName │ mothersName       │
│ INT AI       │ VARCHAR│ VARCHAR   │ VARCHAR  │ VARCHAR     │ VARCHAR           │
│              │ (255)  │ (255)     │ (255)    │ (255)       │ (255)             │
├─────────────────────────────────────────────────────────────────────────────────┤
│ gender │ genotype │ weight │ birthPlace │ pod │ state │ lga │ dateOfBirth      │
│ VARCHAR│ VARCHAR  │ VARCHAR│ VARCHAR    │ VARCHAR│ VARCHAR│ VARCHAR│ DATE      │
│ (10)   │ (10)     │ (255)  │ (255)      │ (255) │ (255) │ (255) │             │
├─────────────────────────────────────────────────────────────────────────────────┤
│ yearOfBirth │ PlaceOfIssue │ regCentre │ dateReg │ father_occupation          │
│ DATE         │ VARCHAR      │ VARCHAR   │ DATE    │ VARCHAR                    │
│              │ (255)        │ (255)     │         │ (255)                      │
├─────────────────────────────────────────────────────────────────────────────────┤
│ father_nationality │ father_religion │ mother_nationality │ payId              │
│ VARCHAR            │ VARCHAR         │ VARCHAR            │ INT                │
│ (255)              │ (255)           │ (255)              │                    │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────┐
│ 4. tbldeath (Death Registrations)                                               │
├─────────────────────────────────────────────────────────────────────────────────┤
│ deathId (PK) │ certNo │ firstName │ lastName │ gender │ state │ lga │ address  │
│ INT AI       │ VARCHAR│ VARCHAR   │ VARCHAR  │ VARCHAR│ VARCHAR│ VARCHAR│ VARCHAR │
│              │ (255)  │ (255)     │ (255)    │ (10)   │ (255) │ (255) │ (255)   │
├─────────────────────────────────────────────────────────────────────────────────┤
│ ageAtDeath │ placeOfDeath │ dateOfDeath │ PlaceOfIssue │ regCentre │ dateReg  │
│ INT(10)    │ VARCHAR      │ DATE        │ VARCHAR      │ VARCHAR   │ DATE     │
│            │ (255)        │             │ (255)        │ (255)     │          │
├─────────────────────────────────────────────────────────────────────────────────┤
│ cause_death │ payId                                                             │
│ VARCHAR     │ INT                                                               │
│ (255)       │                                                                   │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────┐
│ 5. tblcertno (Certificate Number Management)                                    │
├─────────────────────────────────────────────────────────────────────────────────┤
│ Id (PK) │ certId │ lastCertId                                                   │
│ INT AI  │ VARCHAR│ VARCHAR                                                      │
│         │ (20)   │ (20)                                                         │
└─────────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                RELATIONSHIPS                                    │
└─────────────────────────────────────────────────────────────────────────────────┘

1. tbladmin ──────(Many-to-One)──────► tblcentre
   (RegCentre FK → centreId PK)

2. tblcentre ─────(One-to-Many)──────► tblbirth
   (centreName → regCentre)

3. tblcentre ─────(One-to-Many)──────► tbldeath
   (centreName → regCentre)

4. tblcertno ─────(One-to-Many)──────► tblbirth
   (certId '100000' → certNo generation)

5. tblcertno ─────(One-to-Many)──────► tbldeath
   (certId '200000' → certNo generation)

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                CARDINALITY                                      │
└─────────────────────────────────────────────────────────────────────────────────┘

• One Registration Center can have Many Administrators
• One Registration Center can process Many Birth Registrations
• One Registration Center can process Many Death Registrations
• One Certificate Type can generate Many Certificate Numbers
• Each Administrator belongs to Exactly One Registration Center
• Each Birth Registration is processed at Exactly One Center
• Each Death Registration is processed at Exactly One Center

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                CONSTRAINTS                                      │
└─────────────────────────────────────────────────────────────────────────────────┘

PRIMARY KEY CONSTRAINTS:
• adminId (tbladmin)
• centreId (tblcentre)
• birthId (tblbirth)
• deathId (tbldeath)
• Id (tblcertno)

UNIQUE CONSTRAINTS:
• email (tbladmin)
• username (tbladmin)
• certNo (tblbirth)
• certNo (tbldeath)
• centreName within state (tblcentre)

FOREIGN KEY CONSTRAINTS:
• tbladmin.RegCentre → tblcentre.centreId
• tblbirth.regCentre → tblcentre.centreName
• tbldeath.regCentre → tblcentre.centreName

CHECK CONSTRAINTS:
• gender IN ('Male', 'Female')
• dateOfBirth <= CURRENT_DATE
• dateOfDeath <= CURRENT_DATE
• ageAtDeath > 0
• payId IN (0, 1)

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                DATA FLOW                                        │
└─────────────────────────────────────────────────────────────────────────────────┘

REGISTRATION PROCESS:
1. Administrator Login (tbladmin)
2. Create Registration (tblbirth/tbldeath)
3. Generate Certificate Number (tblcertno)
4. Process Payment (update payId)
5. Print Certificate

REPORTING PROCESS:
1. Query by Date Range
2. Filter by Center
3. Generate Statistics
4. Export Data

┌─────────────────────────────────────────────────────────────────────────────────┐
│                                INDEXES                                          │
└─────────────────────────────────────────────────────────────────────────────────┘

PRIMARY INDEXES:
• adminId, centreId, birthId, deathId, Id

SECONDARY INDEXES:
• email, username (tbladmin)
• certNo (tblbirth, tbldeath)
• dateReg (tblbirth, tbldeath)
• RegCentre (tbladmin) 