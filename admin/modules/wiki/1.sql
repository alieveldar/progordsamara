SELECT
  `auto_lenta`.`id`, `auto_lenta`.`name`, `auto_lenta`.`data`, `auto_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link`
FROM
  `auto_lenta`
     LEFT JOIN `_pages`
       ON `_pages`.`link`='auto'
WHERE (`auto_lenta`.`stat`='1' && `auto_lenta`.`onind`='1')
GROUP BY 1)

UNION

(SELECT `business_lenta`.`id`, `business_lenta`.`name`, `business_lenta`.`data`, `business_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link` FROM `business_lenta` LEFT JOIN `_pages` ON `_pages`.`link`='business' WHERE (`business_lenta`.`stat`='1' && `business_lenta`.`onind`='1') GROUP BY 1)

UNION

(SELECT `news_lenta`.`id`, `news_lenta`.`name`, `news_lenta`.`data`, `news_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link` FROM `news_lenta` LEFT JOIN `_pages` ON `_pages`.`link`='news' WHERE (`news_lenta`.`stat`='1' && `news_lenta`.`onind`='1') GROUP BY 1)

UNION

(SELECT `sport_lenta`.`id`, `sport_lenta`.`name`, `sport_lenta`.`data`, `sport_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link` FROM `sport_lenta` LEFT JOIN `_pages` ON `_pages`.`link`='sport' WHERE (`sport_lenta`.`stat`='1' && `sport_lenta`.`onind`='1') GROUP BY 1)

UNION

(SELECT `concurs_lenta`.`id`, `concurs_lenta`.`name`, `concurs_lenta`.`data`, `concurs_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link` FROM `concurs_lenta` LEFT JOIN `_pages` ON `_pages`.`link`='concurs' WHERE (`concurs_lenta`.`stat`='1' && `concurs_lenta`.`onind`='1') GROUP BY 1)

UNION

(SELECT `demotivators_lenta`.`id`, `demotivators_lenta`.`name`, `demotivators_lenta`.`data`, `demotivators_lenta`.`pic`, `_pages`.`domain`, `_pages`.`link` FROM `demotivators_lenta` LEFT JOIN `_pages` ON `_pages`.`link`='demotivators' WHERE (`demotivators_lenta`.`stat`='1' && `demotivators_lenta`.`onind`='1') GROUP BY 1) ORDER BY `data` DESC LIMIT 6