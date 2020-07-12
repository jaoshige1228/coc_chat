-- 前向 ララ
insert into chars(
  name,
  sex,
  age,
  job,
  str,
  dex,
  intel,
  con,
  app,
  pow,
  siz,
  san,
  maxSan,
  edu,
  hp,
  mp,
  idea,
  luck,
  know,
  db,
  profile,
  subProfile,
  sum_jobP,
  sum_hobP,
  sum_etcP,
  icon
) values(
  -- name,
  '前向 ララ',
  -- sex,
  '女',
  -- age,
  '18',
  -- job,
  '案内人',
  -- str,
  7,
  -- dex,
  11,
  -- intel,
  15,
  -- con,
  9,
  -- app,
  16,
  -- pow,
  17,
  -- siz,
  10,
  -- san,
  80,
  -- maxSan,
  80,
  -- edu,
  12,
  -- hp,
  10,
  -- mp,
  17,
  -- idea,
  75,
  -- luck,
  85,
  -- know,
  60,
  -- db,
  '-1d4',
  -- profile,
  '常に前向きな少女。\r日々の幸せを記録することを、人々に促しているとかいないとか。',
  -- subProfile,
  'このキャラクターは評価者用に自動生成されたキャラです',
  -- sum_jobP,
  240,
  -- sum_hobP,
  150,
  -- sum_etcP,
  0,
  -- icon
  'thumbs/Lara.png'
);

insert into skills(
  -- charId,
      回避,
      頭突き,
      応急手当,
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学,
      母国語
    ) 
    values(
      -- 1,
      72,
      60,
      80,
      85,
      61,
      75,
      70,
      75,
      65,
      60
    );

insert into sum_jobP(
  -- charId,
      聞き耳,
      精神分析,
      図書館,
      ナビゲート,
      説得,
      心理学
    ) 
    values(
      -- 1,
      40,
      40,
      40,
      40,
      40,
      40
    );
   
   insert into sum_hobP(
  -- charId,
      回避,
      頭突き,
      応急手当
    ) 
    values(
      -- 1,
      50,
      50,
      50
    );

   insert into skills_def(
  -- charId,
      回避,
      母国語
    ) 
    values(
      -- 1,
      22,
      60
    );


-- 山田・サンプル・太郎
insert into chars(
  name,
  sex,
  age,
  job,
  str,
  dex,
  intel,
  con,
  app,
  pow,
  siz,
  san,
  maxSan,
  edu,
  hp,
  mp,
  idea,
  luck,
  know,
  db,
  profile,
  subProfile,
  sum_jobP,
  sum_hobP,
  sum_etcP,
  icon
) values(
  -- name,
  '山田・サンプル・太郎',
  -- sex,
  '男',
  -- age,
  '25',
  -- job,
  'サンプル提供者',
  -- str,
  11,
  -- dex,
  11,
  -- intel,
  15,
  -- con,
  11,
  -- app,
  11,
  -- pow,
  11,
  -- siz,
  13,
  -- san,
  55,
  -- maxSan,
  55,
  -- edu,
  12,
  -- hp,
  12,
  -- mp,
  11,
  -- idea,
  75,
  -- luck,
  55,
  -- know,
  60,
  -- db,
  '0',
  -- profile,
  'サンプルとして誕生した、平均的な男。',
  -- subProfile,
  'このキャラクターは評価者用に自動生成されたキャラです',
  -- sum_jobP,
  150,
  -- sum_hobP,
  240,
  -- sum_etcP,
  0,
  -- icon
  'thumbs/sample.png'
);

-- insert into skills(
--   charId,
--     回避,
--       こぶし,
--       目星,
--       聞き耳,
--       図書館,
--       コンピューター
--     ) 
--     values(
--       2,
--       72,
--       100,
--       75,
--       75,
--       75,
--       51
--     );

-- insert into sum_jobP(
--   charId,
--       回避,
--       こぶし,
--       目星,
--       聞き耳
--     ) 
--     values(
--       2,
--       50,
--       50,
--       50,
--       50
--     );
   
--    insert into sum_hobP(
--   charId,
--       図書館,
--       コンピューター
--     ) 
--     values(
--       2,
--       50,
--       50
--     );

--    insert into skills_def(
--   charId,
--       回避,
--       母国語
--     ) 
--     values(
--       2,
--       22,
--       50
--     );