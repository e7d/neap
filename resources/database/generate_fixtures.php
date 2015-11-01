<?php
    class UUID
    {
        public static function v4()
        {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
    }

    function makeSeed()
    {
      list($usec, $sec) = explode(' ', microtime());
      return (float) $sec + ((float) $usec * 100000);
    }
    mt_srand(makeSeed());

    function big_rand($min, $max)
    {
        $difference   = bcadd(bcsub($max, $min),1);
        $rand_percent = bcdiv(mt_rand(), mt_getrandmax(), 8); // 0 - 1.0
        return bcadd($min, bcmul($difference, $rand_percent, 8), 0);
    }

    date_default_timezone_set('UTC');
    function timestamp_rand($min = 0, $max = NULL)
    {
        if ($max === NULL) {
            $max = microtime(true);
        }

        return big_rand($min * 10000, $max * 10000) / 10000;
    }

    function timestampToDate($timestamp)
    {
        $timestamp = number_format($timestamp, 4, '.', '');
        $date = \DateTime::createFromFormat('U.u', $timestamp);
        return $date->format("Y-m-d H:i:s.uO");
    }

    // data
    $topics = array(
        UUID::v4() => 'Mathematics',
        UUID::v4() => 'Science',
        UUID::v4() => 'Astrology',
        UUID::v4() => 'Litterature',
        UUID::v4() => 'Biology',
        UUID::v4() => 'History',
        UUID::v4() => 'Theology',
        UUID::v4() => 'Philosophy',
        UUID::v4() => 'Music',
        UUID::v4() => 'Photography',
        UUID::v4() => 'Video games',
    );
    $users = array('Noah', 'Liam', 'Mason', 'Jacob', 'William', 'Ethan', 'Michael', 'Alexander', 'James', 'Daniel', 'Elijah', 'Benjamin', 'Logan', 'Aiden', 'Jayden', 'Matthew', 'Jackson', 'David', 'Lucas', 'Joseph', 'Anthony', 'Andrew', 'Samuel', 'Gabriel', 'Joshua', 'John', 'Carter', 'Luke', 'Dylan', 'Christopher', 'Isaac', 'Oliver', 'Henry', 'Sebastian', 'Caleb', 'Owen', 'Ryan', 'Nathan', 'Wyatt', 'Hunter', 'Jack', 'Christian', 'Landon', 'Jonathan', 'Levi', 'Jaxon', 'Julian', 'Isaiah', 'Eli', 'Aaron', 'Charles', 'Connor', 'Cameron', 'Thomas', 'Jordan', 'Jeremiah', 'Nicholas', 'Evan', 'Adrian', 'Gavin', 'Robert', 'Brayden', 'Grayson', 'Josiah', 'Colton', 'Austin', 'Angel', 'Jace', 'Dominic', 'Kevin', 'Brandon', 'Tyler', 'Parker', 'Ayden', 'Jason', 'Jose', 'Ian', 'Chase', 'Adam', 'Hudson', 'Nolan', 'Zachary', 'Easton', 'Jaxson', 'Cooper', 'Lincoln', 'Xavier', 'Bentley', 'Kayden', 'Carson', 'Brody', 'Asher', 'Nathaniel', 'Ryder', 'Justin', 'Leo', 'Juan', 'Luis', 'Camden', 'Tristan', 'Damian', 'Elias', 'Vincent', 'Jase', 'Mateo', 'Maxwell', 'Miles', 'Micah', 'Sawyer', 'Jesus', 'Max', 'Roman', 'Leonardo', 'Santiago', 'Cole', 'Carlos', 'Bryson', 'Ezra', 'Brantley', 'Braxton', 'Declan', 'Eric', 'Kaiden', 'Giovanni', 'Theodore', 'Harrison', 'Alex', 'Diego', 'Wesley', 'Bryce', 'Ivan', 'Greyson', 'George', 'Timothy', 'Weston', 'Silas', 'Jonah', 'Antonio', 'Colin', 'Richard', 'Hayden', 'Ashton', 'Steven', 'Axel', 'Miguel', 'Kaleb', 'Bryan', 'Preston', 'Jayce', 'Ryker', 'Victor', 'Patrick', 'Joel', 'Grant', 'Emmett', 'Alejandro', 'Marcus', 'Jameson', 'Edward', 'Kingston', 'Jude', 'Maddox', 'Abel', 'Emmanuel', 'Bennett', 'Everett', 'Brian', 'Jeremy', 'Alan', 'Kaden', 'Jaden', 'Riley', 'Jesse', 'King', 'Tucker', 'Kai', 'Kyle', 'Malachi', 'Abraham', 'Ezekiel', 'Calvin', 'Oscar', 'Bradley', 'Luca', 'Avery', 'Aidan', 'Zayden', 'Mark', 'Jake', 'Kenneth', 'Maximus', 'Sean', 'Karter', 'Brady', 'Nicolas', 'Cayden', 'Caden', 'Graham', 'Jayceon', 'Paul', 'Gage', 'Corbin', 'Peter', 'Derek', 'Maverick', 'Jorge', 'Tanner', 'Jax', 'Peyton', 'Xander', 'Amir', 'Gael', 'Omar', 'Iker', 'Javier', 'Elliot', 'Jasper', 'Rylan', 'Cody', 'Dean', 'Andres', 'Collin', 'Zane', 'Charlie', 'Myles', 'Lorenzo', 'Beau', 'Conner', 'Lukas', 'Simon', 'Francisco', 'Elliott', 'Finn', 'Gunner', 'Garrett', 'Jaiden', 'Keegan', 'Rowan', 'Israel', 'Griffin', 'August', 'Judah', 'Beckett', 'Brooks', 'Zander', 'Spencer', 'Chance', 'Damien', 'Seth', 'Waylon', 'Travis', 'Devin', 'Emiliano', 'Zion', 'Ricardo', 'Erick', 'Stephen', 'Reid', 'Paxton', 'Eduardo', 'Martin', 'Fernando', 'Raymond', 'Manuel', 'Jeffrey', 'Felix', 'Dallas', 'Josue', 'Mario', 'Clayton', 'Caiden', 'Cristian', 'Troy', 'Cash', 'Trevor', 'Shane', 'Kameron', 'Cesar', 'Emilio', 'Andy', 'Tyson', 'Andre', 'Donovan', 'Titus', 'Knox', 'River', 'Kyler', 'Louis', 'Cruz', 'Hector', 'Holden', 'Rafael', 'Landen', 'Lane', 'Jared', 'Edwin', 'Messiah', 'Johnny', 'Edgar', 'Johnathan', 'Alexis', 'Archer', 'Anderson', 'Trenton', 'Arthur', 'Sergio', 'Marco', 'Julius', 'Dominick', 'Milo', 'Dalton', 'Remington', 'Dante', 'Angelo', 'Gregory', 'Reed', 'Jaylen', 'Marshall', 'Dawson', 'Leon', 'Drew', 'Shawn', 'Emerson', 'Fabian', 'Joaquin', 'Walker', 'Erik', 'Desmond', 'Karson', 'Emanuel', 'Jett', 'Ali', 'Kendrick', 'Aden', 'Frank', 'Walter', 'Rhett', 'Colt', 'Amari', 'Romeo', 'Cohen', 'Roberto', 'Maximiliano', 'Grady', 'Barrett', 'Zaiden', 'Drake', 'Gideon', 'Major', 'Brendan', 'Skyler', 'Derrick', 'Pedro', 'Phoenix', 'Noel', 'Ruben', 'Braden', 'Nehemiah', 'Dakota', 'Cade', 'Kamden', 'Quinn', 'Nash', 'Kason', 'Ronan', 'Allen', 'Porter', 'Enzo', 'Atticus', 'Kash', 'Jay', 'Adan', 'Finley', 'Matteo', 'Malik', 'Abram', 'Braylon', 'Ace', 'Solomon', 'Gunnar', 'Clark', 'Orion', 'Ismael', 'Kellan', 'Brennan', 'Corey', 'Tate', 'Philip', 'Thiago', 'Phillip', 'Esteban', 'Jayson', 'Dexter', 'Jensen', 'Pablo', 'Ronald', 'Dillon', 'Muhammad', 'Armando', 'Bruce', 'Gerardo', 'Brycen', 'Marcos', 'Kade', 'Kolton', 'Damon', 'Braylen', 'Russell', 'Leland', 'Milan', 'Prince', 'Gannon', 'Enrique', 'Keith', 'Rory', 'Brock', 'Donald', 'Tobias', 'Chandler', 'Deacon', 'Cason', 'Raul', 'Ty', 'Scott', 'Landyn', 'Mohamed', 'Colby', 'Danny', 'Leonel', 'Kayson', 'Warren', 'Adriel', 'Dustin', 'Taylor', 'Albert', 'Ryland', 'Hugo', 'Keaton', 'Jamison', 'Ari', 'Malcolm', 'Ellis', 'Kellen', 'Maximilian', 'Davis', 'Saul', 'Tony', 'Rocco', 'Zachariah', 'Jerry', 'Julio', 'Franklin', 'Arjun', 'Ibrahim', 'Nico', 'Jaxton', 'Jakob', 'Izaiah', 'Moises', 'Cyrus', 'Lawrence', 'Sullivan', 'Finnegan', 'Khalil', 'Mathew', 'Case', 'Jaime', 'Alec', 'Pierce', 'Quentin', 'Kasen', 'Darius', 'Colten', 'Royce', 'Odin', 'Kane', 'Francis', 'Raiden', 'Trey', 'Daxton', 'Gustavo', 'Rhys', 'Alijah', 'Lawson', 'Beckham', 'Moses', 'Rodrigo', 'Armani', 'Uriel', 'Dennis', 'Marvin', 'Harvey', 'Kian', 'Raylan', 'Darren', 'Frederick', 'Mohammed', 'Trent', 'Jonas', 'Zayne', 'Callen', 'Matias', 'Mitchell', 'Kyrie', 'Uriah', 'Tristen', 'Sterling', 'Theo', 'Larry', 'Randy', 'Korbin', 'Alberto', 'Chris', 'Gianni', 'Killian', 'Princeton', 'Arturo', 'Ricky', 'Malakai', 'Aarav', 'Asa', 'Jimmy', 'Alfredo', 'Alonzo', 'Benson', 'Braydon', 'Devon', 'Curtis', 'Casey', 'Justice', 'Roy', 'Sam', 'Legend', 'Dorian', 'Nikolai', 'Kobe', 'Winston', 'Arlo', 'Reece', 'Lance', 'Wade', 'Cannon', 'Augustus', 'Hayes', 'Hendrix', 'Isaias', 'Neymar', 'Ahmed', 'Jaxen', 'Nasir', 'Brayan', 'Issac', 'Ronin', 'Talon', 'Boston', 'Moshe', 'Orlando', 'Vihaan', 'Gary', 'Bowen', 'Luka', 'Nikolas', 'Yahir', 'Joe', 'Leonidas', 'Quinton', 'Luciano', 'Ezequiel', 'Ayaan', 'Ahmad', 'Jalen', 'Royal', 'Jamari', 'Noe', 'Kieran', 'Mauricio', 'Conor', 'Johan', 'Matthias', 'Bryant', 'Mathias', 'Maurice', 'Roger', 'Lennox', 'Nathanael', 'Nixon', 'Mohammad', 'Yusuf', 'Eddie', 'Kristopher', 'Tatum', 'Jacoby', 'Wilson', 'Alvin', 'Raphael', 'Lewis', 'Douglas', 'Mekhi', 'Salvador', 'Eden', 'Hank', 'Cullen', 'Dax', 'Toby', 'Rayan', 'Emmitt', 'Lucian', 'Jefferson', 'Casen', 'London', 'Roland', 'Carl', 'Crosby', 'Bodhi', 'Dominik', 'Niko', 'Zackary', 'Deandre', 'Hamza', 'Remy', 'Quincy', 'Alessandro', 'Sincere', 'Dane', 'Terry', 'Otto', 'Samson', 'Madden', 'Jasiah', 'Layne', 'Santino', 'Rohan', 'Abdullah', 'Brentley', 'Marc', 'Skylar', 'Bo', 'Kyson', 'Soren', 'Harley', 'Nelson', 'Layton', 'Payton', 'Aldo', 'Atlas', 'Ramon', 'Reese', 'Conrad', 'Morgan', 'Ernesto', 'Byron', 'Carmelo', 'Sage', 'Neil', 'Kristian', 'Oakley', 'Tomas', 'Flynn', 'Lionel', 'Kylan', 'Leonard', 'Rex', 'Brett', 'Jeffery', 'Duke', 'Sylas', 'Callan', 'Tripp', 'Bruno', 'Zechariah', 'Melvin', 'Branson', 'Blaine', 'Jon', 'Julien', 'Arian', 'Guillermo', 'Zain', 'Rayden', 'Brodie', 'Crew', 'Memphis', 'Kelvin', 'Stanley', 'Joey', 'Emery', 'Terrance', 'Channing', 'Edison', 'Lennon', 'Demetrius', 'Amos', 'Cayson', 'Rodney', 'Cory', 'Elian', 'Xzavier', 'Bronson', 'Bentlee', 'Lee', 'Dayton', 'Chad', 'Cassius', 'Jagger', 'Fletcher', 'Omari', 'Alonso', 'Yosef', 'Westin', 'Brenden', 'Makai', 'Felipe', 'Harry', 'Alden', 'Maxim', 'Nickolas', 'Davion', 'Forrest', 'Allan', 'Enoch', 'Willie', 'Ben', 'Terrence', 'Tommy', 'Adonis', 'Cain', 'Harper', 'Callum', 'Jermaine', 'Kody', 'Thaddeus', 'Ray', 'Kamari', 'Aydin', 'Zeke', 'Markus', 'Ariel', 'Elisha', 'Lucca', 'Marcelo', 'Shaun', 'Aryan', 'Vicente', 'Aron', 'Keagan', 'Marlon', 'Langston', 'Ulises', 'Anders', 'Kareem', 'Bobby', 'Davian', 'Kendall', 'Ronnie', 'Jadiel', 'Samir', 'Alexzander', 'Hassan', 'Kingsley', 'Axton', 'Trace', 'Will', 'Jamal', 'Valentino', 'Yousef', 'Brecken', 'Fisher', 'Giovani', 'Kaysen', 'Maxton', 'Mayson', 'Van', 'Hezekiah', 'Blaze', 'Kolten', 'Misael', 'Javon', 'Kolby', 'Rogelio', 'Ares', 'Jedidiah', 'Bode', 'Leandro', 'Cedric', 'Jamie', 'Rowen', 'Urijah', 'Wayne', 'Eugene', 'Kole', 'Camron', 'Darian', 'Billy', 'Kase', 'Rene', 'Duncan', 'Adrien', 'Alfred', 'Maison', 'Apollo', 'Braeden', 'Mack', 'Clyde', 'Reginald', 'Anson', 'Jerome', 'Ishaan', 'Jessie', 'Javion', 'Micheal', 'Vincenzo', 'Camdyn', 'Gauge', 'Keenan', 'Gerald', 'Franco', 'Junior', 'Justus', 'Jamir', 'Marley', 'Terrell', 'Giancarlo', 'Braiden', 'Brantlee', 'Draven', 'Titan', 'Harold', 'Landry', 'Zayn', 'Briggs', 'Kyree', 'Chaim', 'Dilan', 'Joziah', 'Marquis', 'Jonathon', 'Azariah', 'Kenny', 'Amare', 'Brent', 'Clay', 'Stetson', 'Tyrone', 'Blaise', 'Dariel', 'Lamar', 'Reuben', 'Alfonso', 'Axl', 'Stefan', 'Finnley', 'Marcel', 'Jaydon', 'Kalel', 'Triston', 'Darrell', 'Steve', 'Abdiel', 'Lyric', 'Gibson', 'Thatcher', 'Henrik', 'Jadon', 'Jairo', 'Rudy', 'Castiel', 'Emory', 'Hugh', 'Konnor', 'Graysen', 'Cristiano', 'Deshawn', 'Eliezer', 'Kamdyn', 'Miller', 'Rylee', 'Tristian', 'Agustin', 'Ernest', 'Dwayne', 'Dimitri', 'Ford', 'Rey', 'Zavier', 'Arnav', 'Santana', 'Vance', 'Jamarion', 'Ramiro', 'Sonny', 'Brice', 'Leighton', 'Gilbert', 'Jordyn', 'Kaeden', 'Anton', 'Coen', 'Salvatore', 'Seamus', 'Zaire', 'Aaden', 'Chevy', 'Lachlan', 'Rolando', 'Aydan', 'Darwin', 'Randall', 'Santos', 'Yael', 'Grey', 'Kohen', 'Rashad', 'Jayse', 'Lochlan', 'Mustafa', 'Johnathon', 'Kannon', 'Konner', 'Jovani', 'Maximo', 'Alvaro', 'Clinton', 'Aidyn', 'Kymani', 'Davin', 'Jordy', 'Ephraim', 'Frankie', 'Heath', 'Houston', 'Kamron', 'Craig', 'Cristopher', 'Gordon', 'Harlan', 'Turner', 'Vaughn', 'Vivaan', 'Ameer', 'Gavyn', 'Gino', 'Jovanni', 'Benton', 'Rodolfo', 'Dominique', 'Jaycob', 'Jericho', 'Augustine', 'Coleman', 'Dash', 'Eliseo', 'Khalid', 'Quintin', 'Makhi', 'Zaid', 'Anakin', 'Baylor', 'Emmet', 'Judson', 'Truman', 'Camilo', 'Efrain', 'Semaj', 'Camren', 'Damari', 'Kamryn', 'Deangelo', 'Giovanny', 'Mike', 'Dario', 'Kale', 'Broderick', 'Jayvion', 'Kaison', 'Koen', 'Magnus', 'Darien', 'Teagan', 'Valentin', 'Bodie', 'Brayson', 'Chace', 'Kylen', 'Yehuda', 'Bridger', 'Howard', 'Maddux', 'Osvaldo', 'Rocky', 'Ayan', 'Boden', 'Foster', 'Jair', 'Reyansh', 'Tyree', 'Ean', 'Leif', 'Reagan', 'Rylen', 'Emma', 'Olivia', 'Sophia', 'Isabella', 'Ava', 'Mia', 'Emily', 'Abigail', 'Madison', 'Charlotte', 'Sofia', 'Elizabeth', 'Amelia', 'Evelyn', 'Ella', 'Chloe', 'Victoria', 'Aubrey', 'Grace', 'Zoey', 'Natalie', 'Addison', 'Lillian', 'Brooklyn', 'Lily', 'Hannah', 'Layla', 'Scarlett', 'Aria', 'Zoe', 'Samantha', 'Anna', 'Leah', 'Audrey', 'Ariana', 'Allison', 'Savannah', 'Arianna', 'Camila', 'Penelope', 'Gabriella', 'Claire', 'Aaliyah', 'Sadie', 'Nora', 'Sarah', 'Hailey', 'Kaylee', 'Paisley', 'Kennedy', 'Ellie', 'Annabelle', 'Caroline', 'Madelyn', 'Serenity', 'Aubree', 'Lucy', 'Alexa', 'Nevaeh', 'Stella', 'Violet', 'Genesis', 'Mackenzie', 'Bella', 'Autumn', 'Mila', 'Kylie', 'Maya', 'Piper', 'Alyssa', 'Eleanor', 'Melanie', 'Naomi', 'Faith', 'Eva', 'Katherine', 'Lydia', 'Brianna', 'Julia', 'Ashley', 'Khloe', 'Madeline', 'Ruby', 'Sophie', 'Alexandra', 'Lauren', 'Gianna', 'Isabelle', 'Alice', 'Vivian', 'Hadley', 'Jasmine', 'Kayla', 'Cora', 'Bailey', 'Kimberly', 'Hazel', 'Clara', 'Sydney', 'Trinity', 'Natalia', 'Valentina', 'Jocelyn', 'Maria', 'Aurora', 'Eliana', 'Brielle', 'Liliana', 'Mary', 'Elena', 'Molly', 'Makayla', 'Lilly', 'Andrea', 'Adalynn', 'Nicole', 'Delilah', 'Kinsley', 'Paige', 'Mariah', 'Brooke', 'Willow', 'Jade', 'Lyla', 'Mya', 'Ximena', 'Luna', 'Isabel', 'Mckenzie', 'Ivy', 'Josephine', 'Amy', 'Laila', 'Isla', 'Adalyn', 'Angelina', 'Londyn', 'Rachel', 'Melody', 'Juliana', 'Kaitlyn', 'Brooklynn', 'Destiny', 'Gracie', 'Norah', 'Emilia', 'Elise', 'Sara', 'Aliyah', 'Margaret', 'Catherine', 'Vanessa', 'Katelyn', 'Gabrielle', 'Arabella', 'Valeria', 'Valerie', 'Adriana', 'Everly', 'Jessica', 'Daisy', 'Makenzie', 'Summer', 'Lila', 'Rebecca', 'Julianna', 'Callie', 'Michelle', 'Ryleigh', 'Presley', 'Alaina', 'Angela', 'Alina', 'Harmony', 'Rose', 'Athena', 'Adelyn', 'Alana', 'Izabella', 'Cali', 'Esther', 'Fiona', 'Stephanie', 'Cecilia', 'Kate', 'Kinley', 'Jayla', 'Genevieve', 'Alexandria', 'Eliza', 'Kylee', 'Alivia', 'Giselle', 'Arya', 'Alayna', 'Leilani', 'Adeline', 'Jennifer', 'Tessa', 'Ana', 'Melissa', 'Daniela', 'Aniyah', 'Daleyza', 'Keira', 'Lucia', 'Hope', 'Gabriela', 'Mckenna', 'Brynlee', 'Lola', 'Amaya', 'Miranda', 'Maggie', 'Anastasia', 'Leila', 'Lexi', 'Georgia', 'Kenzie', 'Iris', 'Jacqueline', 'Cassidy', 'Vivienne', 'Camille', 'Noelle', 'Adrianna', 'Josie', 'Juliette', 'Annabella', 'Allie', 'Juliet', 'Kendra', 'Sienna', 'Brynn', 'Kali', 'Maci', 'Danielle', 'Haley', 'Jenna', 'Raelynn', 'Delaney', 'Paris', 'Alexia', 'Gemma', 'Lilliana', 'Chelsea', 'Evangeline', 'Ayla', 'Kayleigh', 'Lena', 'Katie', 'Elaina', 'Olive', 'Madeleine', 'Makenna', 'Elsa', 'Nova', 'Nadia', 'Alison', 'Kaydence', 'Journey', 'Jada', 'Kathryn', 'Shelby', 'Nina', 'Elliana', 'Diana', 'Phoebe', 'Alessandra', 'Eloise', 'Nyla', 'Madilyn', 'Adelynn', 'Miriam', 'Ashlyn', 'Amiyah', 'Megan', 'Amber', 'Rosalie', 'Annie', 'Lilah', 'Charlee', 'Amanda', 'Ruth', 'Adelaide', 'June', 'Laura', 'Daniella', 'Mikayla', 'Raegan', 'Jane', 'Ashlynn', 'Kelsey', 'Erin', 'Christina', 'Joanna', 'Fatima', 'Allyson', 'Talia', 'Mariana', 'Sabrina', 'Haven', 'Ainsley', 'Cadence', 'Elsie', 'Leslie', 'Heaven', 'Arielle', 'Maddison', 'Alicia', 'Briella', 'Lucille', 'Malia', 'Selena', 'Heidi', 'Kyleigh', 'Kira', 'Lana', 'Sierra', 'Kiara', 'Paislee', 'Alondra', 'Daphne', 'Carly', 'Jaylah', 'Kyla', 'Bianca', 'Baylee', 'Cheyenne', 'Macy', 'Camilla', 'Catalina', 'Gia', 'Vera', 'Skye', 'Aylin', 'Sloane', 'Myla', 'Yaretzi', 'Giuliana', 'Macie', 'Veronica', 'Esmeralda', 'Lia', 'Averie', 'Addyson', 'Mckinley', 'Ada', 'Carmen', 'Mallory', 'Jillian', 'Ariella', 'Rylie', 'Abby', 'Scarlet', 'Bethany', 'Elle', 'Jazmin', 'Aspen', 'Camryn', 'Malaysia', 'Haylee', 'Nayeli', 'Gracelyn', 'Kamila', 'Helen', 'Marilyn', 'April', 'Carolina', 'Amina', 'Julie', 'Raelyn', 'Blakely', 'Angelique', 'Miracle', 'Emely', 'Jayleen', 'Kennedi', 'Amira', 'Briana', 'Gwendolyn', 'Zara', 'Aleah', 'Itzel', 'Bristol', 'Francesca', 'Emersyn', 'Aubrie', 'Karina', 'Nylah', 'Kelly', 'Anaya', 'Maliyah', 'Evelynn', 'Ember', 'Melany', 'Angelica', 'Jimena', 'Madelynn', 'Kassidy', 'Tiffany', 'Kara', 'Jazmine', 'Jayda', 'Dahlia', 'Alejandra', 'Sarai', 'Annabel', 'Holly', 'Janelle', 'Braelyn', 'Gracelynn', 'Viviana', 'Serena', 'Brittany', 'Annalise', 'Brinley', 'Madisyn', 'Eve', 'Cataleya', 'Joy', 'Caitlyn', 'Anabelle', 'Emmalyn', 'Journee', 'Celeste', 'Brylee', 'Luciana', 'Marlee', 'Savanna', 'Anya', 'Marissa', 'Jazlyn', 'Zuri', 'Kailey', 'Crystal', 'Michaela', 'Lorelei', 'Guadalupe', 'Madilynn', 'Maeve', 'Hanna', 'Priscilla', 'Kyra', 'Lacey', 'Nia', 'Charley', 'Juniper', 'Cynthia', 'Karen', 'Sylvia', 'Aleena', 'Caitlin', 'Felicity', 'Elisa', 'Julissa', 'Rebekah', 'Evie', 'Helena', 'Imani', 'Karla', 'Millie', 'Lilian', 'Raven', 'Harlow', 'Leia', 'Kailyn', 'Lillie', 'Amara', 'Kadence', 'Lauryn', 'Cassandra', 'Kaylie', 'Madalyn', 'Anika', 'Hayley', 'Bria', 'Colette', 'Henley', 'Regina', 'Alanna', 'Azalea', 'Fernanda', 'Jaliyah', 'Anabella', 'Adelina', 'Lilyana', 'Skyla', 'Addisyn', 'Zariah', 'Bridget', 'Braylee', 'Monica', 'Gloria', 'Johanna', 'Addilyn', 'Danna', 'Selah', 'Aryanna', 'Kaylin', 'Aniya', 'Willa', 'Angie', 'Kaia', 'Kaliyah', 'Anne', 'Tiana', 'Charleigh', 'Winter', 'Danica', 'Alayah', 'Aisha', 'Bailee', 'Kenley', 'Aileen', 'Lexie', 'Janiyah', 'Braelynn', 'Liberty', 'Katelynn', 'Mariam', 'Sasha', 'Lindsey', 'Montserrat', 'Cecelia', 'Mikaela', 'Kaelyn', 'Rosemary', 'Annika', 'Tatiana', 'Marie', 'Virginia', 'Liana', 'Matilda', 'Freya', 'Lainey', 'Hallie', 'Audrina', 'Blake', 'Hattie', 'Monserrat', 'Kiera', 'Laylah', 'Greta', 'Alyson', 'Emilee', 'Maryam', 'Melina', 'Dayana', 'Jaelynn', 'Beatrice', 'Frances', 'Elisabeth', 'Saige', 'Kensley', 'Meredith', 'Aranza', 'Rosa', 'Shiloh', 'Charli', 'Elyse', 'Alani', 'Mira', 'Lylah', 'Linda', 'Whitney', 'Alena', 'Jaycee', 'Joselyn', 'Ansley', 'Kynlee', 'Miah', 'Tenley', 'Breanna', 'Emelia', 'Maia', 'Edith', 'Pearl', 'Anahi', 'Coraline', 'Samara', 'Demi', 'Chanel', 'Kimber', 'Lilith', 'Malaya', 'Jemma', 'Myra', 'Bryanna', 'Laney', 'Jaelyn', 'Kaylynn', 'Kallie', 'Natasha', 'Nathalie', 'Perla', 'Amani', 'Lilianna', 'Madalynn', 'Blair', 'Elianna', 'Karsyn', 'Lindsay', 'Elaine', 'Dulce', 'Ellen', 'Erica', 'Maisie', 'Renata', 'Kiley', 'Marina', 'Remi', 'Emmy', 'Ivanna', 'Amirah', 'Livia', 'Amelie', 'Irene', 'Mabel', 'Cara', 'Ciara', 'Kathleen', 'Jaylynn', 'Caylee', 'Lea', 'Erika', 'Paola', 'Alma', 'Courtney', 'Mae', 'Kassandra', 'Maleah', 'Leyla', 'Mina', 'Ariah', 'Christine', 'Jasmin', 'Kora', 'Chaya', 'Karlee', 'Lailah', 'Mara', 'Jaylee', 'Raquel', 'Siena', 'Desiree', 'Hadassah', 'Kenya', 'Aliana', 'Wren', 'Amiya', 'Isis', 'Zaniyah', 'Avah', 'Amia', 'Cindy', 'Eileen', 'Madyson', 'Celine', 'Aryana', 'Everleigh', 'Isabela', 'Reyna', 'Teresa', 'Jolene', 'Marjorie', 'Myah', 'Clare', 'Claudia', 'Leanna', 'Noemi', 'Corinne', 'Simone', 'Alia', 'Brenda', 'Dorothy', 'Emilie', 'Elin', 'Tori', 'Martha', 'Ally', 'Arely', 'Leona', 'Patricia', 'Sky', 'Thalia', 'Carolyn', 'Nataly', 'Paityn', 'Shayla', 'Averi', 'Jazlynn', 'Margot', 'Lisa', 'Lizbeth', 'Nancy', 'Deborah', 'Ivory', 'Khaleesi', 'Meadow', 'Yareli', 'Farrah', 'Milania', 'Janessa', 'Milana', 'Zoie', 'Adele', 'Clarissa', 'Lina', 'Sariah', 'Emmalynn', 'Galilea', 'Hailee', 'Halle', 'Sutton', 'Giana', 'Thea', 'Denise', 'Naya', 'Kristina', 'Liv', 'Nathaly', 'Wendy', 'Aubrielle', 'Brenna', 'Danika', 'Monroe', 'Celia', 'Dana', 'Jolie', 'Taliyah', 'Miley', 'Yamileth', 'Jaylene', 'Saylor', 'Joyce', 'Milena', 'Zariyah', 'Sandra', 'Ariadne', 'Aviana', 'Mollie', 'Cherish', 'Alaya', 'Asia', 'Nola', 'Penny', 'Dixie', 'Marisol', 'Adrienne', 'Kori', 'Kristen', 'Aimee', 'Esme', 'Laurel', 'Aliza', 'Roselyn', 'Sloan', 'Lorelai', 'Jenny', 'Katalina', 'Lara', 'Amya', 'Ayleen', 'Aubri', 'Ariya', 'Carlee', 'Iliana', 'Magnolia', 'Aurelia', 'Evalyn', 'Natalee', 'Rayna', 'Heather', 'Collins', 'Estrella', 'Hana', 'Kenna', 'Jordynn', 'Rosie', 'Aiyana', 'America', 'Angeline', 'Janiya', 'Jessa', 'Tegan', 'Susan', 'Emmalee', 'Taryn', 'Temperance', 'Alissa', 'Kenia', 'Abbigail', 'Briley', 'Kailee', 'Zaria', 'Chana', 'Lillianna', 'Barbara', 'Carla', 'Aliya', 'Bonnie', 'Keyla', 'Marianna', 'Paloma', 'Jewel', 'Joslyn', 'Saniyah', 'Audriana', 'Giovanna', 'Hadleigh', 'Mckayla', 'Jaida', 'Salma', 'Sharon', 'Emmaline', 'Kimora', 'Wynter', 'Avianna', 'Amalia', 'Karlie', 'Kaidence', 'Kairi', 'Libby', 'Sherlyn', 'Diamond', 'Holland', 'Zendaya', 'Mariyah', 'Zainab', 'Alisha', 'Ayanna', 'Ellison', 'Harlee', 'Lilyanna', 'Bryleigh', 'Julianne', 'Kaleigh', 'Miya', 'Yasmin', 'Anniston', 'Estelle', 'Emmeline', 'Faye', 'Kiana', 'Anabel', 'Tara', 'Astrid', 'Emerie', 'Sidney', 'Zahra', 'Jaylin', 'Kinslee', 'Tabitha', 'Aubriella', 'Addilynn', 'Alyvia', 'Hadlee', 'Ingrid', 'Lilia', 'Macey', 'Azaria', 'Kaitlynn', 'Neriah', 'Annabell', 'Ariyah', 'Janae', 'Kaiya', 'Reina', 'Rivka', 'Alisa', 'Marleigh', 'Alisson', 'Maliah', 'Mercy', 'Noa', 'Scarlette', 'Clementine', 'Frida', 'Ann', 'Sonia', 'Alannah', 'Avalynn', 'Dalia', 'Ayva', 'Stevie', 'Judith', 'Paulina', 'Estella', 'Gwen', 'Mattie', 'Milani', 'Raina', 'Julieta', 'Renee', 'Lesly', 'Abrielle', 'Bryn', 'Carlie', 'Riya', 'Abril', 'Aubrianna', 'Jocelynn', 'Kylah', 'Louisa', 'Pyper', 'Antonia', 'Magdalena', 'Moriah', 'Ryann', 'Tamia', 'Kailani', 'Aya', 'Ireland', 'Mercedes', 'Rosalyn', 'Alaysia', 'Annalee', 'Patience', 'Aanya', 'Paula', 'Samiyah', 'Yaritza', 'Cordelia', 'Nala', 'Belen', 'Cambria', 'Natalya', 'Kaelynn');
    shuffle($users);
    $users = array_slice($users, 0, mt_rand(100, 500));
    $streamTitles = array(
        '{{user}} goes live!',
        'Fun with {{topic}} and {{user}}',
        '{{topic}}?? Yeah, {{topic}}!',
        'Today is {{topic}} day',
        'Come on and have fun with {{user}}!',
        'The origins of {{topic}}',
        'Relax stream',
    );
    $streamDefinitions = array(
        array('width' => 1920, 'height' => 1080, 'bitrateMin' => 1000, 'bitrateMax' => 3500),
        array('width' => 1280, 'height' => 720, 'bitrateMin' => 750, 'bitrateMax' => 1500),
        array('width' => 720, 'height' => 400, 'bitrateMin' => 500, 'bitrateMax' => 800),
    );

    $sql  = 'SET search_path TO pg_catalog,public,"neap";'.PHP_EOL;
    $sql .= 'BEGIN;'.PHP_EOL;
    $sql .= 'SET CONSTRAINTS ALL DEFERRED;'.PHP_EOL;

    foreach ($topics as $topicId => $topicName) {
        $topicCreatedAt = timestampToDate(timestamp_rand(1420070400));

        $sql .= <<<SQL
INSERT INTO "neap"."topic"(topic_id, name, created_at)
    VALUES ('$topicId', '$topicName', '$topicCreatedAt');

SQL;
    }

    foreach ($users as $userDisplayName) {
        // IDs
        $userId = UUID::v4();
        $channelId = UUID::v4();
        $chatId = UUID::v4();

        // User
        $username = strtolower($userDisplayName);
        $userEmail = $username.'@neap.io';
        $userPassword = password_hash($username, PASSWORD_BCRYPT, ['cost' => 10]);
        $userLogo = 'https://gravatar.com/avatar/'.md5($userEmail).'?s=128&d=identicon';
        $userCreatedAtTimestamp = timestamp_rand(1420070400);
        $userCreatedAt = timestampToDate($userCreatedAtTimestamp);
        $userUpdatedAt = timestampToDate(timestamp_rand($userCreatedAtTimestamp));

        $sql .= <<<SQL
INSERT INTO "neap"."user"(user_id, channel_id, type, username, email, password, display_name, logo, bio, created_at, updated_at)
    VALUES ('$userId', '$channelId', 'user', '$username', '$userEmail', '$userPassword', '$userDisplayName', '$userLogo', null, '$userCreatedAt', '$userUpdatedAt');

SQL;

        // Channel
        $channelStreamKey = UUID::v4();
        $channelTopicId = array_rand($topics);
        $channelTopic = $topics[$channelTopicId];
        $channelLanguage = 'en';
        $channelDelay = mt_rand(0, 9) > 8 ? mt_rand(10, 120) : 0;
        $channelLogo = null;
        $channelBanner = null;
        $channelVideoBanner = null;
        $channelBackground = null;
        $channelProfileBanner = null;
        $channelViews = mt_rand(0, 100000);
        $channelFollowers = mt_rand(0, 150);
        $channelCreatedAtTimestamp = timestamp_rand($userCreatedAtTimestamp);
        $channelCreatedAt = timestampToDate($channelCreatedAtTimestamp);
        $channelUpdatedAt = timestampToDate(timestamp_rand($channelCreatedAtTimestamp));

        $sql .= <<<SQL
INSERT INTO "neap"."channel"(channel_id, user_id, chat_id, name, display_name, topic, language, views, followers)
    VALUES ('$channelId', '$userId', '$chatId', '$username', '$userDisplayName Channel', '$channelTopic', 'en', $channelViews, $channelFollowers);

SQL;

        // Chat
        $sql .= <<<SQL
INSERT INTO "neap"."chat"(chat_id, channel_id, name)
    VALUES ('$chatId', '$channelId', '$username');

SQL;

        // Streams
        for ($streamIndex = 0; $streamIndex < mt_rand(0, 20); $streamIndex++) {
            $streamId = UUID::v4();
            $streamTopicId = array_rand($topics);
            $streamTopic = $topics[$streamTopicId];
            $streamTitle = str_replace(
                array('{{user}}', '{{topic}}'),
                array($userDisplayName, $streamTopic),
                $streamTitles[array_rand($streamTitles)]
            );
            $streamDefinition = $streamDefinitions[array_rand($streamDefinitions)];
            $streamMediaInfo = json_encode(array(
                'width' => $streamDefinition['width'],
                'height' => $streamDefinition['height'],
                'bitrate' => mt_rand($streamDefinition['bitrateMin'] * 100, $streamDefinition['bitrateMax'] * 100) / 100,
            ));
            $streamViewers = mt_rand(0, 9) > 8 ? mt_rand(0, 100000) : mt_rand(0, 2000);
            $streamCreatedAtTimestamp = timestamp_rand($userCreatedAtTimestamp);
            $streamCreatedAt = timestampToDate($streamCreatedAtTimestamp);
            $streamUpdatedAtTimestamp = timestamp_rand($streamCreatedAtTimestamp, $streamCreatedAtTimestamp + mt_rand(0, 10 * 3600));
            $streamUpdatedAt = timestampToDate($streamUpdatedAtTimestamp);
            $streamEndedAt = timestampToDate(timestamp_rand($streamUpdatedAtTimestamp, $streamUpdatedAtTimestamp + mt_rand(0, 2 * 3600)));

            $sql .= <<<SQL
INSERT INTO "neap"."stream"(stream_id, channel_id, title, topic_id, topic, media_info, viewers, created_at, updated_at, ended_at)
    VALUES ('$streamId', '$channelId', '$streamTitle', '$streamTopicId', '$streamTopic', '$streamMediaInfo', $streamViewers, '$streamCreatedAt', '$streamUpdatedAt', '$streamEndedAt');

SQL;

            // Videos
            for ($videoIndex = 0; $videoIndex < mt_rand(0, 2); $videoIndex++) {
                $videoId = UUID::v4();
                $videoTitle = $streamTitle;
                $videoType = mt_rand(0, 5) === 5 ? 'highlight' : 'record';
                $videoDescription = $streamTitle;
                $videoStatus = $recorded;
                $videoTags = json_encode(array());
                $videoTopicId = $streamTopicId;
                $videoTopic = $streamTopic;
                $videoMediaInfo = json_encode(array(
                    'width' => $streamDefinition['width'],
                    'height' => $streamDefinition['height'],
                    'bitrate' => mt_rand($streamDefinition['bitrateMin'] * 100, $streamDefinition['bitrateMax'] * 100) / 100,
                ));
                $videoPreview = null;
                $videoViews = mt_rand(0, 40000);
                $videoCreatedAtTimestamp = timestamp_rand($streamCreatedAtTimestamp);
                $videoCreatedAt = timestampToDate($videoCreatedAtTimestamp);
                $videoUpdatedAt = timestampToDate(timestamp_rand($videoCreatedAtTimestamp, $videoCreatedAtTimestamp + mt_rand(0, 7 * 24 * 3600)));

                $sql .= <<<SQL
INSERT INTO "neap"."video"(video_id, stream_id, title, type, description, status, tags, topic_id, topic, media_info, preview, views, created_at, updated_at)
    VALUES ('$videoId', '$streamId', '$videoTitle', '$videoType', '$videoDescription', '$videoStatus', '$videoTags', '$videoTopicId', '$videoTopic', '$videoMediaInfo', '$videoPreview', '$videoViews', '$videoCreatedAt', '$videoUpdatedAt');

SQL;
            }
        }
        echo '.';
    }

    $sql .= 'COMMIT;'.PHP_EOL;

    file_put_contents('fixtures.sql', $sql);
