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