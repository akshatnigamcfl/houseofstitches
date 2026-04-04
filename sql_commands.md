# DB2 (SpangleDBnew) SQL Commands

## Connection
```
sqlcmd -S 91.203.132.17,59087 -U sbnx_spangle -P Spangle@5654 -d SpangleDBnew -No
```

---

## General

### List all tables
```sql
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME
GO
```

### Show first 10 rows of a table
```sql
SELECT TOP 10 * FROM TABLE_NAME
GO
```

### Show columns of a table
```sql
SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'TABLE_NAME'
ORDER BY ORDINAL_POSITION
GO
```

---

## Trn_ScanCode

### Show columns
```sql
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Trn_ScanCode' ORDER BY ORDINAL_POSITION
GO
```

### Search by barcode
```sql
SELECT * FROM Trn_ScanCode WHERE Scn_Code = '8670230215'
GO
```

---

## Mst_ItemMaster

### Show columns
```sql
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Mst_ItemMaster' ORDER BY ORDINAL_POSITION
GO
```

### Key columns
- `Itm_No`   — Primary key (links to Scn_ItmNo in Trn_ScanCode)
- `Itm_Code` — Article number (maps to products.article_number in local DB)
- `Itm_Desc` — Item description
- `Itm_Rate` — Wholesale rate
- `Itm_MRP`  — MRP

---

## Table Relationships (confirmed)

### Trn_ScanCode → Mst_ItemMaster
- `Trn_ScanCode.Scn_ItmNo` = `Mst_ItemMaster.Itm_No`

### Find item details from barcode
```sql
SELECT
    s.Scn_Code,
    s.Scn_Size,
    s.Scn_BatchCode,
    i.Itm_No,
    i.Itm_Code,
    i.Itm_Desc,
    i.Itm_Rate,
    i.Itm_MRP
FROM Trn_ScanCode s
JOIN Mst_ItemMaster i ON i.Itm_No = s.Scn_ItmNo
WHERE s.Scn_Code = '8670230215'
GO
```

---

## Trn_StockDetails

### Show columns
```sql
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Trn_StockDetails' ORDER BY ORDINAL_POSITION
GO
```

### Show first 10 rows
```sql
SELECT TOP 10 * FROM Trn_StockDetails
GO
```

### Trn_StockDetails key columns
- `Stk_No`       — Primary key
- `Stk_ItmNo`    — FK → Mst_ItemMaster.Itm_No
- `Stk_Size`     — Size
- `Stk_StockQty` — Stock quantity
- `Stk_BatchCode`— Batch code

### Trn_StockDetails → Mst_ItemMaster
- `Trn_StockDetails.Stk_ItmNo` = `Mst_ItemMaster.Itm_No`

### Active stock for a specific item (by Itm_No)
```sql
SELECT
    i.Itm_Code,
    i.Itm_Desc,
    sd.Stk_Size,
    sd.Stk_StockQty,
    sd.Stk_BatchCode
FROM Trn_StockDetails sd
JOIN Mst_ItemMaster i ON i.Itm_No = sd.Stk_ItmNo
WHERE sd.Stk_ItmNo = 86713010
AND sd.Stk_StockQty > 0
GO
```

### Active stock via barcode
```sql
SELECT
    i.Itm_Code,
    i.Itm_Desc,
    sd.Stk_Size,
    sd.Stk_StockQty,
    sd.Stk_BatchCode
FROM Trn_ScanCode s
JOIN Mst_ItemMaster i ON i.Itm_No = s.Scn_ItmNo
JOIN Trn_StockDetails sd ON sd.Stk_ItmNo = i.Itm_No
WHERE s.Scn_Code = '8670230215'
AND sd.Stk_StockQty > 0
GO
```

### Find all tables with item-related columns
```sql
SELECT t.name AS TableName, c.name AS ColumnName
FROM sys.tables t
JOIN sys.columns c ON c.object_id = t.object_id
WHERE c.name LIKE '%Itm%' OR c.name LIKE '%Item%'
ORDER BY t.name
GO
```
