# Setup
1. Unzip (or clone) the project
2. Run `composer install` to install composer packages (PHP) (No need to do that if you have the zipped folder).
3. Run `php artisan migrate` to run the DB migrations.
4. Run `php artisan serve` to serve the project.
5. Start adding tasks.
# Task Manager in Larave/Livewire
- This application allows you to create, update, delete tasks as well as mark them as complete/incomplete.
- You can sort tasks by dragging the hamburger icon on each `li` item in the list.
- You can also prioritize tasks using drag & drop on the tasks list.
- Editing the task is done in the same form that is used to create a new task. Reusability is efficient eh? (PS: even the title changes depending on if you're creating or updating a task. I love the attention to small details :D)

## Common Notes to .. well, note.
- While Vue.js would have been more suitable for this project, I chose to make it in Livewire to demonstrate my PHP/Laravel & Livewire knowledge.
- Marking tasks as complete makes them unavailable for further editing. You can still mark them as incomplete and edit them.
- Sorting notes by priority can be done using the form or the drag & drop. However, drag & drop is better as it organizes the priority integers into a sequence.
- Editing the priority manually will shift tasks with the same and higher priority than the priority entered by 1.

### Questions that might come to your head..
- Why not make a separate livewire component for the form and list?
    - Well, while this might have made things easier, I, above all, follow the `KISS` principle. `Keep It Simple Stupid`. I asked myself `Does the project need that extra layer of complexity?` I found the answer to be `No`.
- Why MySQL and not SQLite?
    - Project Requirements. For this simple project, I'd have chosen `SQLite`.
- Why is the design ... not great?
    - Ouch, that hurt my feelings :(. But to be fair, design isn't really my cup of tea.
---
If you have any other questions, reach me on michaelyousrie@gmail.com
