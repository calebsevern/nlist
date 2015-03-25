#Experiments

###Create an Experiment
To open a new experiment, click on **Experiments > Create New**.
After creating an experiment, you will be redirected to the experiment's home page.

###Experiment Lists
There are options for viewing **Current**,  **Completed**, and **All** experiments. These overviews will list relevant experiments; click on one to view details like sessions, details, and documents.


###The Experiment View
Click on an experiment and you will see its details, documents, and all sessions associated with the experiment. You may edit experiment details at any point, and mark the experiment as finished from the appropriate card. Below that, you will find a **Documents** section, where you can upload any documents pertinent to the experiment. You may also choose to share the file URLs with participants. In the **Sessions** card to the right, each session will be listed with at-a-glance information - click on one for more information.

---

#Sessions

###Create a Session
To add a session, simply click the **+** button in the **Sessions** card on any experiment page. Note that experiments are used to group multiple sessions together.

###The Session View
On the left, you will see session details, including date information and required/reserve participants.  Session details will be sent to participants through recruiting/reminder emails. The **Date** value is chosen with a date picker - you can also enter a DD/MM/YYYY value if you prefer, or if your browser does not support the provided date picker. 

You may select the **Time** through a dropdown menu, or specify your own in the HH:MMpm/HH:MM/am format.

The **Reminder Timer** is used to schedule reminder emails - e.g., a value of 48 will send a reminder email 48 hours before the experiment is scheduled to start. 

The **Duration** field holds the session's length in an HH:MM:SS format. You may select this value through the provided dropdown, or define your own in a HH:MM:SS format. 

To the right, you will see a **Participants** view. You can invite participants to the session, or add them as a standby candidate. Click the "save" icon in the card's header to save your choices, and the "mail" icon next to it to send off a batch of recruiting emails. You can also search for a participant by name, email, or tag using the search bar in the top right - results are automatically filtered as you type. If a participant has confirmed their intent to attend by clicking a link in the confirmation email, you will see a green check next to their name. If a participant has not clicked the confirmation link, you will see a yellow caution sign - this does not mean a participant will not attend, only that they have not confirmed via the email link.

---

#Participants 

###Create a Participant
To add a participant, click **Participants > Create New**. You will be prompted to enter the participant's name, email, phone, tags, and notes. 

The **Tag** system is used to assign search-able attributes to any participant. For example, you may write "Psychology, MATH240, 3 cats" in this field. When searching for participants to add to a session, you can then type "MATH240" or "3 cats" to find all participants that share that tag.


###The Participants View

Click **Participants > All** for a list of all participants in the system. In the header, you can click the **+** icon to add a participant, or the "upload" icon for bulk uploading from a file. You can also filter participants by any attribute with the search field in the top-right.

Upon clicking the "upload" button, you will be presented with a link to a template and a file dialogue next to it. File uploads will only work properly if you follow the simple CSV convention set forth by the template - most spreadsheet software comes with an "export to .csv" option, and it is recommended that you look at the template before you begin in-person recruiting so that you may collect information accordingly. 

Click on a row to edit/delete that participant. The red button at the bottom of the **Edit Participant** is used for deletion - click once, and the button turns into a confirmation; click twice and the participant will be permanently deleted. 

---

#Utilities

###The Documents View

Click **Utilities > Documents** to view all documents in the system. You can search by name or associated experiment. Clicking a document's name opens that document, and clicking the associated experiment's name takes you to that experiment's page.

###The Email View (Drafting Custom Emails)

Click **Utilities > Documents** to open the custom email view. Here, you will see a WYSIWYG editor you can use to draft custom emails with any formatting you like. You may also enter raw HTML if you have an HTML template you like. To enter experiment/session/participant details, use the following shortcodes. They will be replaced with the appropriate information when emails are sent.

[full_name] - The Participant's full name

[experiment_name] - The Experiment's name

[experiment_description] - The Experiment's description

[start_date]  - Day of the Session

[start_time] - Session's start time

[end_time] - Session's end time

[lab] - The location of the Session

[notes] - Any provided Session notes

[confirmation_link] - The link a participant needs to click to confirm their intent to participate

[proctor_name] - The proctor's full name

[proctor_email] - The proctor's email address, as provided



