CREATE TABLE Individual
(
	iid INT(5) NOT NULL,
	name CHAR(50),
	email CHAR(50),
	bond_number INT(5),
	major CHAR(20),
	graduation_date DATE,
	dues DOUBLE(5,2),
	PRIMARY KEY (iid)
);

DESC Individual;

CREATE TABLE ServiceEvent
(
	sid INT(5) NOT NULL,
	event_name CHAR(50),
	date DATE,
	PRIMARY KEY (sid)
);

DESC ServiceEvent;

CREATE TABLE AttendsService
(
	iid INT(5),
	sid INT(5),
	hours INT(3),
	approval_status CHAR(10),
	PRIMARY KEY (iid, sid),
	FOREIGN KEY (iid) REFERENCES Individual(iid),
	FOREIGN KEY (sid) REFERENCES ServiceEvent(sid)
);

DESC AttendsService;

CREATE TABLE PhilanthropyEvent
(
	pid INT(5) NOT NULL,
	event_name CHAR(50),
	date DATE,
	PRIMARY KEY (pid)
);

DESC PhilanthropyEvent;

CREATE TABLE AttendsPhilanthropy
(
	iid INT(5),
	pid INT(5),
	approval_status CHAR(10),
	PRIMARY KEY (iid, pid),
	FOREIGN KEY (iid) REFERENCES Individual(iid),
	FOREIGN KEY (pid) REFERENCES PhilanthropyEvent(pid)
);

DESC AttendsPhilanthropy;

CREATE TABLE Meeting
(
	mid INT(5) NOT NULL,
	date DATE,
	PRIMARY KEY (mid)
);

DESC Meeting;

CREATE TABLE AttendsMeeting
(
	iid INT(5),
	mid INT(5),
	PRIMARY KEY (iid, mid),
	FOREIGN KEY (iid) REFERENCES Individual(iid),
	FOREIGN KEY (mid) REFERENCES Meeting(mid)
);

DESC AttendsMeeting;

CREATE TABLE Officer
(
	iid INT(5),
	title CHAR(20),
	requirement INT(3),
	PRIMARY KEY (iid, title),
	FOREIGN KEY (iid) REFERENCES Individual(iid)
);

DESC Officer;

CREATE VIEW ServiceHours AS
SELECT iid, SUM(hours)
FROM AttendsService
WHERE approval_status = 'Approved'
GROUP BY iid;

CREATE VIEW PhilanthropyAmount AS
SELECT iid, COUNT(*)
FROM AttendsPhilanthropy
WHERE approval_status = 'Approved'
GROUP BY iid;

INSERT INTO Individual
VALUES(1, 'James Bond', 'james.bond@case.edu', 7, 'Philosophy', NOW(), 112.20);

INSERT INTO Individual
VALUES(2, 'Master Chief', 'jmc117@case.edu', 117, 'Accounting', NOW(), 0.00);

INSERT INTO Individual
VALUES(3, 'Abraham Lincoln', 'honest.abe@case.edu', 16, 'Civil Engineering', NOW(), 50.55);

INSERT INTO Individual
VALUES(4, 'Chuck Norris', 'cfn@case.edu', 1, 'Mathematics', NOW(), 0.00);

INSERT INTO Individual
VALUES(5, 'John Ronal Ruel Tolkien', 'jrt4@case.edu', 9, 'Nursing', NOW(), 75.00);

INSERT INTO Officer
VALUES(1, 'Treasurer', 200);

INSERT INTO Officer
VALUES(2, 'Service Chair', 5);

INSERT INTO Officer
VALUES(3, 'Philanthropy Chair', 2);

INSERT INTO ServiceEvent
VALUES(1, 'Cleveland Food Bank', '2015-10-22');

INSERT INTO ServiceEvent
VALUES(2, 'Saturday Tutoring', '2015-11-07');

INSERT INTO AttendsService
VALUES(1, 1, 3, 'New');

INSERT INTO AttendsService
VALUES(2, 1, 1, 'New');

INSERT INTO AttendsService
VALUES(2, 2, 2, 'New');