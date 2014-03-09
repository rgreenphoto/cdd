START TRANSACTION;

-- Fix the divisions one at a time
-- Dual Division only needs a registration table update
UPDATE registration 
SET division_id = '45'
WHERE competition_id = '74' AND division_id = '31';

UPDATE competition_fee 
SET division_id = '45'
WHERE competition_id = '74' AND division_id = '31';

-- Intermediate needs both reg and results
UPDATE registration
SET division_id = '46'
WHERE competition_id = '74' AND division_id = '32';

UPDATE competition_result
SET division_id = '46'
WHERE competition_id = '74' AND division_id = '32';

UPDATE competition_fee
SET division_id = '46'
WHERE competition_id = '74' AND division_id = '32';

-- Novice division needs both
UPDATE registration
SET division_id = '47'
WHERE competition_id = '74' AND division_id = '33';

UPDATE competition_result
SET division_id = '47'
WHERE competition_id = '74' AND division_id = '33';

UPDATE competition_fee
SET division_id = '47'
WHERE competition_id = '74' AND division_id = '33';

-- Open needs both
UPDATE registration
SET division_id = '48'
WHERE competition_id = '74' AND division_id = '34';

UPDATE competition_result
SET division_id = '48'
WHERE competition_id = '74' AND division_id = '34';

UPDATE competition_fee
SET division_id = '48'
WHERE competition_id = '74' AND division_id = '34';

-- Advanced needs both
UPDATE registration
SET division_id = '49'
WHERE competition_id = '74' AND division_id = '35';

UPDATE competition_result
SET division_id = '49'
WHERE competition_id = '74' AND division_id = '35';

UPDATE competition_fee
SET division_id = '49'
WHERE competition_id = '74' AND division_id = '35';

-- update competition type
UPDATE competition
SET competition_type_id = '11'
WHERE id = '74';

UPDATE `competition_result` 
SET `division_id` = '49', `tc_cat_1` = 'N/C,N/C,2.5', `tc_total_1` = '2.5', `dual` = '1' 
WHERE `id` = '1969';

UPDATE `competition_result`
SET `dual` = '1'
WHERE `id` = '1983';
COMMIT;



