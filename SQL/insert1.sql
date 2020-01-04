insert into User(AccessRightsID, Username, Password) values(1,'patient1','pa1');
insert into User(AccessRightsID, Username, Password) values(1,'patient2','pa2');
insert into User(AccessRightsID, Username, Password) values(1,'patient3','pa3');
insert into User(AccessRightsID, Username, Password) values(3,'therapist1','thp1');
insert into User(AccessRightsID, Username, Password) values(3,'therapist2','thp2');
insert into User(AccessRightsID, Username, Password) values(4,'doctor1','dr1');
insert into User(AccessRightsID, Username, Password) values(4,'doctor2','dr2');
insert into User(AccessRightsID, Username, Password) values(5,'receptionist1','rcp1');
insert into User(AccessRightsID, Username, Password) values(5,'receptionist2','rcp2');

insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(1,'Julie', 'Lemoyne', '5153430343', 26);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(2,'Marc', 'Gagnon', '5143788732', 22);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(3,'Nancy', 'Chatlin', '4502228867', 33);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(4,'Luc', 'Gosselin', '4388343482', 29);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(5,'Forest', 'Gump', '4502832936', 48);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(6,'Morgan', 'Reilly', '4812342896', 26);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(7,'Vanessa', 'Lemay', '5149909876', 22);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(8,'Myriam', 'Brisebois', '5148340274', 25);
insert into UserInformation(UserID, First_Name, Last_Name, Phone_Number, age) values(9,'Amelie', 'Moreau', '4389992246', 38);

insert into Doctor(UserID, Experience) values(6,10);
insert into Doctor(UserID, Experience) values(7,6);

insert into Therapist(UserID, Experience) values(4,5);
insert into Therapist(UserID, Experience) values(5,4);

insert into Patient(UserID) values(1);
insert into Patient(UserID) values(2);
insert into Patient(UserID) values(3);

insert into Receptionist(UserID) values(8);
insert into Receptionist(UserID) values(9);