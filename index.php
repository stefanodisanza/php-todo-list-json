<!DOCTYPE html>
<html>

<head>
    <title>Todo List</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/47e16b9a1e.js" crossorigin="anonymous"></script>
</head>

<body>

    <div id="app">
        <h1>Todo List</h1>
        <ul class="todo-list">
            <input type="text" v-model="newTodoText">
            <button @click="addTodo">Aggiungi</button>
            <li v-for="todo in todos" class="todo-item" v-bind:class="{ completed: todo.completed }">
                <span class="todo-text" @click="toggleTodoCompletion(todo)">{{ todo.text }}</span>
                <button class="delete-button" @click="deleteTodo(todo)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </li>
        </ul>

    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                todos: [],
                newTodoText: ''
            },
            methods: {
                addTodo() {
                    axios.post('server.php', {
                            text: this.newTodoText
                        })
                        .then(response => {
                            this.todos.push({
                                text: this.newTodoText
                            });
                            this.newTodoText = '';
                        });
                },
                toggleTodoCompletion(todo) {
                    todo.completed = !todo.completed;
                    axios.post('server.php', {
                        id: todo.id,
                        completed: todo.completed
                    });
                },
                deleteTodo(todo) {
                    this.todos = this.todos.filter(t => t !== todo);
                    axios.post('server.php', {
                        id: todo.id,
                        action: 'delete'
                    });
                }
            },
            mounted() {
                axios.get('server.php')
                    .then(response => {
                        this.todos = response.data;
                    });
            }
        });
    </script>
</body>

</html>