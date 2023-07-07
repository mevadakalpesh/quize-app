import axios from 'axios';

function getQuizes(data){
  return axios.post(route('quize.getQuizes'),data);
}

function deleteQuize(data){
  return axios.delete(route('quize.destroy',data));
}

function addQuizeHistory(data){
  return axios.post(route('userSaveQuizeHistory'),data);
}

function getUserDataByQuizeId(data){
  return axios.post(route('getUserDataByQuizeId'),data);
}


const QuizeService = {
  getQuizes,
  deleteQuize,
  addQuizeHistory,
  getUserDataByQuizeId
}
export default QuizeService;
