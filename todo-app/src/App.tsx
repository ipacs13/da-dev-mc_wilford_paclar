import React, { useState, useEffect } from "react";
import axios from "axios";
import TodoList from "./components/TodoList";
import AddTodo from "./components/AddTodo";
import "./App.css";

interface Todo {
  id: number;
  description: string;
  completed: boolean;
}

const App: React.FC = () => {
  const [todos, setTodos] = useState<Todo[]>([]);

  useEffect(() => {
    fetchTodos();
  }, []);

  const fetchTodos = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/todos");
      console.log(response);
      setTodos(response.data.data);
    } catch (error) {
      console.log(error);
    }
  };

  const refreshTodoList = async () => {
    await fetchTodos();
  };

  return (
    <div className="App">
      <AddTodo refreshTodoList={refreshTodoList} />
      <TodoList
        todos={todos}
        setTodos={setTodos}
        refreshTodoList={refreshTodoList}
      />
    </div>
  );
};

export default App;
