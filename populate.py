from lxml import html
import requests
import psycopg2
# from pymongo import MongoClient

#connecting to PostgreSQL
conn = psycopg2.connect(database="ldap", user="postgres", password="snowkid_1x", host="localhost", port="2357")
#creating a database
#Dictionary that stores all the data
database = dict()
#populating above database dictionary
homePage = requests.get('http://ldap1.iitd.ernet.in/LDAP/courses/gpaliases.html')
coursesTree = html.fromstring(homePage.content)
courses = coursesTree.xpath('//a/text()')	#list that contains all the courses names

for course in courses :
	courseURL = 'http://ldap1.iitd.ernet.in/LDAP/courses/'+course+'.shtml'
	coursePage = requests.get(courseURL)
	courseTree = html.fromstring(coursePage.content)
	studentEntryNumbers = courseTree.xpath('//td[@align="LEFT"]/text()')	#Entrynumbers of students taking this course
	studentNames = courseTree.xpath('//tr/td[2]/text()')	#names of students taking this course
	i=0
	for entryNumber in studentEntryNumbers :
		try :
			oldList = database[entryNumber]
			oldList.append(course)
		except KeyError:
			newList = list()
			newList.append(studentNames[i])
			newList.append(course)
			database[entryNumber] = newList
		i=i+1
uid = 'me1130654'
print len(database)
for x in database:
	print x,":",database[x]
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
