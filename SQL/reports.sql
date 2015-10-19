# uzupełnienie danych testowych
UPDATE invoices SET Payment_date = Maturity_date-1;
UPDATE invoices SET Payment_date = NULL WHERE Maturity_date>now();
UPDATE invoices SET Payment_date = Maturity_date+5 WHERE Maturity_date BETWEEN '2015-07-01' AND '2015-08-01';

# pomocnicze
DROP VIEW payment_report;
DROP VIEW exceeded_payment;

# Raport wszystkich faktur po terminie płatności od najmłodszych
CREATE VIEW  payment_report AS SELECT invoices.Signature, invoices.Amount, invoices.Maturity_date, invoices.Payment_date, contract.companyName FROM invoices, contract WHERE invoices.id_contract = contract.id ORDER BY Maturity_date DESC ;

# Raport przekroczonych płatności po dacie płatności
CREATE VIEW exceeded_payment AS SELECT companyName, Signature, Amount, Maturity_date, Payment_date FROM payment_report WHERE Payment_date>Maturity_date ORDER BY Payment_date DESC ;

# Suma zapłaconych faktur
SELECT sum(Amount) FROM invoices WHERE Payment_date IS NOT NULL;

# Suma niezapłaconych faktur
SELECT sum(Amount) FROM invoices WHERE Payment_date IS NULL;

# Suma faktur przeterminowanych a niezapłaconych
SELECT sum(Amount) FROM invoices WHERE Payment_date IS NULL AND Maturity_date < now();

# Suma faktur które zapłacono po terminie
SELECT sum(Amount) FROM invoices WHERE Payment_date>Maturity_date;