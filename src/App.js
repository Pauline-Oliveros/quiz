import React from "react";
import Quiz from "./component/Quiz";
import "./styles/App.css";

const App = () => {
  return (
    <div className="app">
      <h1>Multiple-Choice Quiz App</h1>
      <Quiz />
    </div>
  );
};

export default App;