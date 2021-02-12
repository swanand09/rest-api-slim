#!/bin/bash
array=(
/
/per_page
/per_page/
/per_page/1
/per_page/10
/per_page/15
/per_page/599
/per_page/dag
/page
/page/
/page/asa
/page/0
/page/1
/page/2
/search
/search/
/search/learning
/search/learn
/search/century
/search/textbooks
/search/guide
/search/紅樓夢
/search/三國演義
/search/التدريس عبر
/search/edición
/is_original
/is_original/
/is_original/0
/is_original/2
/subject
/subject/
/subject/01
/subject/2
/subject/fd
/subject/003
);
for j in "${array[@]}";
do
  printf "\n----- "https://pressbook.test.api$j" ----\n";
  curl -k -s https://pressbook.test.api$j
  printf "\n\n";
done
