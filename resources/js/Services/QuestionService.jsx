import axios from 'axios';

function getQuestions(data){
  return axios.post(route('question.getQuestions'),data);
}

function deleteQuestion(data){
  return axios.delete(route('question.destroy',data));
}



const QuestionService = {
  getQuestions,
  deleteQuestion
}
export default QuestionService;
