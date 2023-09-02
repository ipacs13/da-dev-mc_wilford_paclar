import React, { useEffect } from "react";
import axios from "axios";

interface Todo {
  id: number;
  description: string;
  completed: boolean;
}

interface TodoListProps {
  todos: Todo[];
  setTodos: React.Dispatch<React.SetStateAction<Todo[]>>;
  refreshTodoList: () => void;
}

const TodoList: React.FC<TodoListProps> = ({
  todos,
  setTodos,
  refreshTodoList,
}) => {
  useEffect(() => {
    fetchTodos();
  }, []);

  const fetchTodos = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/todos");
      console.log(response);
      refreshTodoList();
    } catch (error) {
      console.log(error);
    }
  };

  const handleDeleteTodo = (id: number): void => {
    const confirmed = window.confirm(
      "Are you sure you want to delete this item?"
    );

    if (confirmed) {
      deleteTodoItem(id);
    }
  };

  const deleteTodoItem = async (id: number) => {
    try {
      await axios.delete(`http://localhost:8000/api/todos/${id}`);
      refreshTodoList();
    } catch (error) {
      console.error("Error deleting todo:", error);
    }
  };

  const toggleComplete = async (todoId: number) => {
    try {
      const updatedTodos = todos.map((todo) => {
        if (todo.id === todoId) {
          return { ...todo, completed: !todo.completed };
        }
        return todo;
      });

      setTodos(updatedTodos);

      await axios.put(`http://localhost:8000/api/todos/${todoId}`, {
        completed: !todos.find((todo) => todo.id === todoId)?.completed,
      });
    } catch (error) {
      console.error("Error toggling completion:", error);
    }
  };

  return (
    <div>
      <h1>Todo List</h1>
      <ul>
        {todos.map((todo) => (
          <li key={todo.id} className={todo.completed ? "completed" : ""}>
            <label>
              <input
                type="checkbox"
                checked={todo.completed}
                onChange={() => toggleComplete(todo.id)}
              />
              {todo.description}
            </label>
            <button onClick={() => handleDeleteTodo(todo.id)}>Delete</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default TodoList;
