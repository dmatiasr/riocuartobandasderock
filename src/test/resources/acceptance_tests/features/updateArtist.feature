Feature: The application responds appropriately to all events that correspond to the various forms of update on artists to the system. 

    Background:
        Given that the application has been started
        #And I have successfully logged in as admin

    Scenario: Update one artist on artist's database with one entry
        Given that the artist's database have one artist with name "Matias" and surname "Serra" and nickname "matu"
        When modify this artist with name "Matias" and surname "Serra" and nickname "matu" with new name "Jacinto" and new surname "Serra" and new nickname "matu" , the result is "OK"
        Then the artist's database should have 1 entry
        And the entry should have name "Jacinto" and surname "Serra" and nickname "matu"
        
    Scenario: Update one artist on artist's database with zero entry
    	Given that the artist's database is empty
        When modify this artist with name "Matias" and surname "Serra" and nickname "matu" with new name "Jacinto" and new surname "Serra" and new nickname "matu" , the result is "BAD REQUEST"
        Then  the artist's database should have 0 entry
 
	Scenario: Update one artist on artist's database with two o more entry
      	Given that the artist's database have one artist with name "Matias" and surname "Serra" and nickname "matu"
      	And that the artist's database have one artist with name "Pablo" and surname "Serra" and nickname "matu"
		When modify this artist with name "Matias" and surname "Serra" and nickname "matu" with new name "Pablo" and new surname "Serra" and new nickname "matu" , the result is "CONFLICT"
		Then the artist's database should have 1 entries with name "Pablo" and surname "Serra" and nickname "matu"
		