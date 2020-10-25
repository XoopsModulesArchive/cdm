SET @lang = "";
DELETE
  FROM cdm_meta
 WHERE cd_set = 'COLOUR';
DELETE
  FROM cdm_code
 WHERE cd_set = 'COLOUR';
