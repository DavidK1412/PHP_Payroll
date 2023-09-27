CREATE SCHEMA IF NOT EXISTS PayRollDB;

USE PayRollDB;

CREATE TABLE if not exists Position (
                                        PositionID INT AUTO_INCREMENT,
                                        PositionName varchar(30),
    PRIMARY KEY(PositionID)
    );

CREATE TABLE IF NOT EXISTS CostCenter (
    CostCenterID varchar(36) NOT NULL DEFAULT(UUID()),
    CostCenterName VARCHAR(30) NOT NULL,
    PRIMARY KEY(CostCenterID)
    );

CREATE TABLE if not exists Employee (
    EmployeeUUID varchar(36) NOT NULL DEFAULT(UUID()) UNIQUE,
    EmployeeID VARCHAR(15) NOT NULL UNIQUE,
    EmployeeName VARCHAR(30) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    PositionID INT NOT NULL,
    CostCenterID varchar(36) NOT NULL,
    Wage DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(EmployeeID),
    FOREIGN KEY(PositionID) REFERENCES Position (PositionID),
    FOREIGN KEY(CostCenterID) REFERENCES CostCenter (CostCenterID)
    );

CREATE TABLE Users (
                       UserUUID varchar(36) NOT NULL DEFAULT (UUID()),
                       EmployeeUUID varchar(36) NOT NULL,
                       Username VARCHAR(30) NOT NULL UNIQUE,
                       Password VARCHAR(256) NOT NULL,
                       PRIMARY KEY(UserUUID),
                       FOREIGN KEY(EmployeeUUID) REFERENCES Employee (EmployeeUUID)
);

CREATE TABLE TimeSheet (
                           TimeSheetUUID varchar(36) NOT NULL DEFAULT(UUID()),
                           EmployeeUUID varchar(36) NOT NULL,
                           Date DATE NOT NULL,
                           DaysWorked INT NOT NULL,
                           VacationDays INT NOT NULL,
                           SickDays INT NOT NULL,
                           PRIMARY KEY(TimeSheetUUID),
                           FOREIGN KEY(EmployeeUUID) REFERENCES Employee (EmployeeUUID)
);

CREATE TABLE PayStub (
                         PayStubUUID varchar(36) NOT NULL DEFAULT(UUID()),
                         TimeSheetUUID varchar(36) NOT NULL,
                         EmployeeUUID varchar(36) NOT NULL,
                         Date DATE NOT NULL,
                         GrossPay DECIMAL(10,2) NOT NULL,
                         NetPay DECIMAL(10,2) NOT NULL,
                         PRIMARY KEY(PayStubUUID),
                         FOREIGN KEY(EmployeeUUID) REFERENCES Employee (EmployeeUUID),
                         FOREIGN KEY(TimeSheetUUID) REFERENCES TimeSheet (TimeSheetUUID)
);

CREATE TABLE Loan (
                      LoanUUID varchar(36) NOT NULL DEFAULT(UUID()),
                      EmployeeUUID varchar(36) NOT NULL,
                      Date DATE NOT NULL,
                      Amount DECIMAL(10,2) NOT NULL,
                      TotalQuotes INT NOT NULL,
                      PayedQuotes INT NOT NULL,
                      PayedOff BOOLEAN NOT NULL,
                      PRIMARY KEY(LoanUUID),
                      FOREIGN KEY(EmployeeUUID) REFERENCES Employee (EmployeeUUID)
);

CREATE TABLE LoanPayments (
                              LoanPaymentUUID varchar(36) NOT NULL DEFAULT(UUID()),
                              LoanUUID varchar(36) NOT NULL,
                              Date DATE NOT NULL,
                              Amount DECIMAL(10,2) NOT NULL,
                              PRIMARY KEY(LoanPaymentUUID),
                              FOREIGN KEY(LoanUUID) REFERENCES Loan (LoanUUID)
);

INSERT INTO Position (PositionName) VALUES ('Admin');
INSERT INTO Position (PositionName) VALUES ('Manager');

INSERT INTO CostCenter (CostCenterName) VALUES ('IT');
INSERT INTO CostCenter (CostCenterName) VALUES ('HR');


INSERT INTO Employee (EmployeeID, EmployeeName, Email, PositionID, CostCenterID, Wage)
VALUES ('1015993002', 'David Casallas', 'davidcasallas013@gmail.com', 1, 'b8a98fbf-4c07-11ee-bc0a-80304968d751', 1800000);

INSERT INTO Employee (EmployeeID, EmployeeName, Email, PositionID, CostCenterID, Wage)
VALUES ('10162578954', 'Juan Casallas', 'jrc@gmail.com', 2, ' b8af81f8-4c07-11ee-bc0a-80304968d751', 2600000);

INSERT INTO Users (EmployeeUUID, Username, Password) VALUES ('570d1a63-4c08-11ee-bc0a-80304968d751', 'davidcasallas013', 'a795aebb6064630110ca17fa3c8804382d5e660884889c28ca220327f0108cfd');