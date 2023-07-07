import { Link } from '@inertiajs/react';
import {useState} from 'react';
import {QuizeService} from '@/Services/Index.jsx'
const Question = ({question,quize,quizeHistory}) => {
  
  const getDisableStatus = (question_id) => {
    let status = quizeHistory.filter(history => history.question_id == question_id );
    return status && status.length > 0;
  }

  const [optionDisable,setOptionDisable]= useState(getDisableStatus(question.id))
  const [defaultOptionValue,setDefaultOptionValue]= useState(0);
  const abcdOption = ["A","B","C","D"];
  
  const findHistory = (question_id,option_id) => {
    let status = quizeHistory.filter(history => history.user_answer_option_id == option_id );
    
    return status && status.length > 0 || defaultOptionValue == option_id;
  }
  

  const handleRadioButton = (quize_id,question_id,option_id) => {
      let historyData = {
        quize_id:quize_id,
        question_id:question_id,
        option_id:option_id,
      };
      
      QuizeService.addQuizeHistory(historyData).then(response => {
        if(response.data.status == 200){
          if(optionDisable === false){
            setDefaultOptionValue(option_id);
              setOptionDisable(true)
          }
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
  
  return (
    <div className="card mt-3" >
      <div className="card-header">
        {question.question_name}
      </div>
       <ul className="list-group list-group-flush">
      {
        question.options ?
         question.options.map((option,index) =>
            <li className="list-group-item" >
                {abcdOption[index]} <input type="radio"
                id={`question-${question.id}-${option.id}`}
                name={`question-${question.id}`} 
                disabled={optionDisable}
                checked={findHistory(question.id,option.id)}
                value={option.id}
                onChange={(e) => handleRadioButton(quize.id,question.id,e.target.value)}/>
                <label for={`question-${question.id}-${option.id}`}  className="mx-2">{option.option_name}</label>
            </li>
         )
         :
         'No Option'
      }
      </ul>
    </div>
  )
}
export default Question;