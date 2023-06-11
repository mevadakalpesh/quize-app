import axios from 'axios';

function getQuestions(data){
  return axios.post(route('question.getQuestions'),data);
}

function deleteQuestion(data){
  return axios.delete(route('question.destroy',data));
}

function getQuestionByCategory(data){
  return axios.post(route('getQuestionByCategory'),data);
}

const QuestionService = {
  getQuestions,
  deleteQuestion,
  getQuestionByCategory
}
export default QuestionService;
