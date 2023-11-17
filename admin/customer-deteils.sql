IF EXISTS(SELECT 1 FROM sys.tables WHERE object_id = OBJECT_ID('Customer_Details'))
BEGIN;
    DROP TABLE [Customer_Details];
END;
GO

CREATE TABLE [Customer_Details] (
    [Customer_ID_NO] INTEGER NOT NULL,
    [Customer_Name] VARCHAR(255) NOT NULL,
    [Phone_Number] BIGINT NOT NULL,
    [Alternate_Phone_Number] BIGINT NULL,
    [Connection_Date] VARCHAR (10) NOT NULL,
    [Standard_Charges] BIT NOT NULL,
    [Location_Description] VARCHAR(MAX) NULL,
    PRIMARY KEY ([Phone_Number])
);
GO

INSERT INTO [Customer_Details] (Customer_ID_NO,Customer_Name,Phone_Number,Alternate_Phone_Number,Connection_Date,Standard_Charges,Location_Description)
VALUES
  (46425714,'Aurora Farrell',0796946425,0714792422, '2023-11-06',1,'neque. In'),
  (86434726,'Keane Bradford',0759286434,0726518341,'2022-06-16',0,'mauris sit amet lorem'),
  (48731747,'Echo Harris',0775748731,0747268427,'2020-11-14',1,'vitae velit');



IF EXISTS(SELECT 1 FROM sys.tables WHERE object_id = OBJECT_ID('Consumption'))
BEGIN;
    DROP TABLE [Consumption];
END;
GO

CREATE TABLE [Consumption] (
    [Customer_Name] VARCHAR(255) NULL,
    [Phone_Number] BIGINT NULL,
    [Jan2023] INTEGER NULL,
    [Feb2023] INTEGER NULL,
    [Mar2023] INTEGER NULL,
    [Apr2023] INTEGER NULL
);

GO

INSERT INTO [Consumption] (Customer_Name,Phone_Number,Jan2023,Feb2023, Mar2023, Apr2023)
VALUES
  ('Aurora Farrell',0796946425,6,2,4,8),
  ('Keane Bradford',0759286434,0,10,8,3),
  ('Echo Harris',0775748731,3,9, 7,6);



SELECT * FROM [dbo].[Customer_Details];