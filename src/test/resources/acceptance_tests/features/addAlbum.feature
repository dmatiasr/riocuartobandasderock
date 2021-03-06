Feature: The application responds appropriately to all events that correspond to the various forms of adding new albums to the system. 

    Background:
	Given that the application has been started
	And I have successfully logged in as admin

    Scenario: Add a new album on an empty album's database 
	Given that the album's database is empty
	When I add an album with name "Perdido" and release date "27/12/2000"
	Then the album's database should have 1 entry
	And the entry should have name "Perdido" and release date "2000-12-27" 

    Scenario: Add an existing album
	Given that the database contains an album named "Perdido en un sueno" and release date "2002"
	When I try to add an album named "Perdido en un sueno" and release date "2002" 
	Then the system informs that the album already exists in the database
	And the database does not change

    Scenario: Add an album with the same title but distinct release date 
	Given that the database contains an album named "Perdido en un sueno" with a null release date
	When I try to add an album named "Perdido en un sueno" and release date "2002" 
	Then the database should have a new entry
	And the entry should correspond to an album named "Perdido en un sueno" and release date "2002"

    Scenario: Add an album with the same tittle but distinct release date
	Given that the database contains an album named "Perdido en un sueno" and release date "2002"
	When I try to add an album named "Perdido en un sueno" and release date "2004"
	Then the database should have a new entry
	And the entry should correspond to an album named "Perdido en un sueno" and release date "2004"
