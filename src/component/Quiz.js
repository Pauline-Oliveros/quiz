import React, { useState } from "react";
import Question from "./Question";
import Score from "./Score";
import questions from "../data/questions";

const Quiz = () => {
  const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
  const [score, setScore] = useState(0);
  const [isQuizCompleted, setIsQuizCompleted] = useState(false);

  const handleAnswerClick = (selectedAnswer) => {
    const currentQuestion = questions[currentQuestionIndex];
    if (selectedAnswer === currentQuestion.correctAnswer) {
      setScore(score + 1);
    }

    if (currentQuestionIndex + 1 < questions.length) {
      setCurrentQuestionIndex(currentQuestionIndex + 1);
    } else {
      setIsQuizCompleted(true);
    }
  };

  return (
    <div className="quiz-container">
      {isQuizCompleted ? (
        <Score score={score} totalQuestions={questions.length} />
      ) : (
        <Question
          question={questions[currentQuestionIndex].questionText}
          options={questions[currentQuestionIndex].options}
          handleAnswerClick={handleAnswerClick}
        />
      )}
    </div>
  );
};

export default Quiz;