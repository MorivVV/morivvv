<?php
$dbPDO->execute("DELETE FROM Tmp");
$dbPDO->execute(
"INSERT INTO Tmp (KOD_METER, DATEBIL,DATE_RES,CURDATE)
SELECT KOD_METER, max(DATE_BIL),0,$dateb
FROM BILLING INNER JOIN
	 Объект_счетчики ON BILLING.KOD_METER = Объект_счетчики.ID
WHERE BILLING.DATE_BIL < $dateb
  AND Объект_счетчики.KOD_HOME=$ID
GROUP BY KOD_METER");
$dbPDO->execute(
"UPDATE Tmp INNER JOIN
		BILLING ON Tmp.KOD_METER = BILLING.KOD_METER AND
				   Tmp.DATEBIL = BILLING.DATE_BIL
SET Tmp.LAST_BIL = BILLING.BILLING");
$dbPDO->execute(
"UPDATE Tmp INNER JOIN
		Объект_счетчики ON Tmp.KOD_METER = Объект_счетчики.ID INNER JOIN
		Объект_расценки ON Объект_счетчики.KOD_TYPE = Объект_расценки.KOD_TYPE
SET Tmp.DATE_RES = if(Объект_расценки.DATE_BEG>Tmp.DATE_RES,Объект_расценки.DATE_BEG,Tmp.DATE_RES)
  , Tmp.KOD_TYPE = Объект_счетчики.KOD_TYPE
WHERE Объект_расценки.DATE_BEG <= $dateb");
$dbPDO->execute(
"UPDATE Tmp t
SET t.DATE_RES = (SELECT max(Объект_расценки.DATE_BEG) 
                  FROM Объект_расценки 
				  WHERE t.KOD_TYPE = Объект_расценки.KOD_TYPE 
				    AND Объект_расценки.DATE_BEG <= $dateb)");
$dbPDO->execute(
"UPDATE Tmp INNER JOIN
		Объект_счетчики ON Tmp.KOD_METER = Объект_счетчики.ID INNER JOIN
		Объект_расценки ON Объект_счетчики.KOD_TYPE = Объект_расценки.KOD_TYPE
SET Tmp.CENA = Объект_расценки.BILLING
WHERE Объект_расценки.DATE_BEG = Tmp.DATE_RES");