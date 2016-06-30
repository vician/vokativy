#!/bin/bash


sqlite3 current.sqlite3 "UPDATE surnames SET vokativ = NULL,rule = NULL;"

sqlite3 current.sqlite3 < rules.sql

./exceptions.sh
