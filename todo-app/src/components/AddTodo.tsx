import React, { useState } from "react";
import axios from "axios";

interface AddTodoProps {
  refreshTodoList: () => void;
}

const AddTodo: React.FC<AddTodoProps> = ({ refreshTodoList }) => {
  const [description, setDescription] = useState<string>("");

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    try {
      await axios.post("http://localhost:8000/api/todos", { description });
      setDescription("");
      refreshTodoList();
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div>
      <h1>Add Todo</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
        />
        <button type="submit">Add</button>
      </form>
    </div>
  );
};

export default AddTodo;
