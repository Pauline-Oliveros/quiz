import React from "react";

const Score = ({ score, totalQuestions }) => {
  const percentage = ((score / totalQuestions) * 100).toFixed(2);

  return (
    <div className="score-container">
      <h2>Quiz Completed!</h2>
      <p>
        You scored {score} out of {totalQuestions}.
      </p>
      <p>Percentage: {percentage}%</p>
    </div>
  );
};

export default Score;