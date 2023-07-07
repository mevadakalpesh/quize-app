/**
* convert data into value and lable
* options array
* first column name as value
* second column nams as id
*
*/
import _ from 'underscore';

function selectBoxKeyUpdate(options, key, value) {
  let updateData;
  if (_.isNull(options)) {
    return null;
  }
  if (options && !_.isEmpty(options) && options.length > 0) {
    updateData = options.map((catdata, index) => {
      return {
        value: catdata[key] ? catdata[key]: catdata.value,
        label: catdata[value] ? catdata[value]: catdata.label,
      }
    });
  } else {
    updateData = {
      value: options[key] ? options[key]: options.value,
      label: options[value] ? options[value]: options.label,
    }
  }
  return updateData;
}

export {
  selectBoxKeyUpdate
}