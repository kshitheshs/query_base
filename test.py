from lxml import html
import requests
import psycopg2
# from pymongo import MongoClient

#connecting to PostgreSQL
conn = psycopg2.connect(database="ldap", user="postgres", password="snowkid_1x", host="localhost", port="2357")
#create a cursor
cur = conn.cursor()
#Dictionary that stores all the data
database = dict()
#populating above database dictionary
# homePage = requests.get('http://ldap1.iitd.ernet.in/LDAP/courses/gpaliases.html')
# coursesTree = html.fromstring(homePage.content)
# courses = coursesTree.xpath('//a/text()')	#list that contains all the courses names

# for i in range(strength):
# 	print studentEntryNumbers[i] , studentNames[i]
# print "cid,email,iid,iname,strength"
# print "cid,sid,sname"
# for course in courses :
# 	courseURL = 'http://ldap1.iitd.ernet.in/LDAP/courses/'+course+'.shtml'
# 	coursePage = requests.get(courseURL)
# 	courseTree = html.fromstring(coursePage.content)
# 	if str(course) == "ESL710" or str(course) == "ESQ306":
# 		studentEntryNumbers = courseTree.xpath('//td[@align="LEFT"]/text()')	#Entrynumbers of students taking this course
# 		studentNames = courseTree.xpath('//tr/td[2]/text()')	#names of students taking this course
# 	else:
# 		studentEntryNumbers = courseTree.xpath('//td[@align="LEFT"]/text()')[1:]	#Entrynumbers of students taking this course
# 		studentNames = courseTree.xpath('//tr/td[2]/text()')[1:]	#names of students taking this course
# 	email = str(courseTree.xpath('/html/body/center[1]/h2/font/text()[2]')).strip("[]").split(":")[1].strip("' ")
# 	strength = str(courseTree.xpath('/html/body/center[1]/h3/font/text()')).strip("[]").split()[0].strip("' ")
# 	cid = str(course)
# 	strength = int(strength)
	# for i in range(strength):
	# 	print cid+','+studentEntryNumbers[i]+','+studentNames[i]
	# print cid+','+email+','+studentEntryNumbers[0]+','+studentNames[0]+','+strength
	# cur.execute("INSERT INTO course_info (cid,email,iid,iname,strength) \
    #   VALUES (course, email, studentEntryNumbers[0], studentNames[0], strength )");
	# i = 0
	# for entryNumber in studentEntryNumbers:
	# 	try :
	# 		oldList = database[entryNumber]
	# 		oldList.append(course)
	# 	except KeyError:
	# 		newList = list()
	# 		newList.append(studentNames[i])
	# 		newList.append(course)
	# 		database[entryNumber] = newList
	# 	i=i+1
# cur.execute("COPY course_info FROM '/Users/ram/Desktop/course_info.csv' DELIMITER ',' CSV HEADER;");
# cur.execute("COPY course_student FROM '/Users/ram/Desktop/course_student.csv' DELIMITER ',' CSV HEADER;");
cur.execute("COPY student FROM '/Users/ram/Desktop/student.csv' DELIMITER ',' CSV HEADER;");
conn.commit()
conn.close()

# uid = 'me1130654'
# print len(database)
# for x in database:
# 	print x,":",database[x]
#Now you've entire database stored in 'database' dictionary
# for entryNumber in database :
# 	courseCollection = db[entryNumber[0:5]]
# 	name = database[entryNumber][0]
# 	database[entryNumber].pop(0)
# 	studentDetails = {
# 		"id" : entryNumber,
# 		"year" : entryNumber[3:5],
# 		"name" : name,
# 		"courses" : database[entryNumber]
# 	}
# 	courseCollection.insert(studentDetails)
