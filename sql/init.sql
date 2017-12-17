CREATE TABLE "surnames" (
	`surname`	TEXT,
	`cetnost`	INTEGER NOT NULL DEFAULT 0,
	`vokativ`	TEXT DEFAULT NULL,
	`rule`	TEXT DEFAULT NULL,
	`checked` BOOLEAN DEFAULT NULL
);
