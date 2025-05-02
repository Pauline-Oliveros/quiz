import React from "react";

const Question = ({ question, options, handleAnswerClick }) => {
  return (
    <div className="question-container">
      <h2>{question}</h2>
      <div className="options">
        {options.map((option, index) => (
          <button
            key={index}
            className="option-button"
            onClick={() => handleAnswerClick(option)}
          >
            {option}
          </button>
        ))}
      </div>
    </div>
  );
};

export default Question;