import axios from 'axios';

function getTemplates(data) {
  return axios.post(route('template.getTemplates'), data);
}

function deleteTemplate(data) {
  return axios.delete(route('templates.destroy', data));
}


const SendMailService = {
  getTemplates,
  deleteTemplate
}
export default SendMailService;