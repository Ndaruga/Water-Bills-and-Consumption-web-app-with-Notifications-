IF EXISTS(SELECT 1 FROM sys.tables WHERE object_id = OBJECT_ID('Customer_Details'))
BEGIN;
    DROP TABLE [Customer_Details];
END;
GO

CREATE TABLE [Customer_Details] (
    [ID] INTEGER NOT NULL IDENTITY(1, 1),
    [Customer ID NO] INTEGER NOT NULL,
    [Customer Name] VARCHAR(255) NOT NULL,
    [Phone Number] BIGINT NOT NULL,
    [Alternate Phone Number] BIGINT NULL,
    [Connection Date] VARCHAR (10) NOT NULL,
    [Standard Charges] VARCHAR (3) NOT NULL,
    [Location Description] VARCHAR(MAX) NULL,
    PRIMARY KEY ([Phone Number])
);
GO

INSERT INTO [Customer_Details] ([Customer ID NO],[Customer Name],[Phone Number],[Alternate Phone Number],[Connection Date],[Standard Charges],[Location Description])
VALUES
  (46425714,'Aurora Farrell',0796946425,0714792422, '2023-11-06','Yes','neque. In'),
  (86434726,'Keane Bradford',0759286434,0726518341,'2022-06-16','No','mauris sit amet lorem'),
  (48731747,'Echo Harris',0775748731,0747268427,'2020-11-14','Yes','vitae velit');



IF EXISTS(SELECT 1 FROM sys.tables WHERE object_id = OBJECT_ID('Consumption'))
BEGIN;
    DROP TABLE [Consumption];
END;
GO

CREATE TABLE [Consumption] (
    [Phone Number] BIGINT NOT NULL,
    [Jan 2023] INTEGER NULL,
    [Feb 2023] INTEGER NULL,
    [Mar 2023] INTEGER NULL,
    [Apr 2023] INTEGER NULL
);

GO

-- INSERT INTO [Consumption] ([Jan 2023],[Feb 2023], [Mar 2023], [Apr 2023])
-- VALUES
--   (6,2,4,8),
--   (0,10,8,3),
--   (3,9, 7,6);



SELECT * FROM [dbo].[Customer_Details];
SELECT * FROM [dbo].[Consumption];
