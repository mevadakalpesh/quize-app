import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {
  Head
} from '@inertiajs/react';
import {
  CCard,
  CCardBody,
  CCol,
  CCardHeader,
  CRow
} from '@coreui/react'
import React, {
  useEffect,
  useRef,
  useState
} from 'react';
import _ from 'underscore';
import Select from 'react-select'
import ReactECharts from 'echarts-for-react';
import {QuizeService} from '@/Services/Index.jsx'
import {selectBoxKeyUpdate} from '@/Helper';



export default function Dashboard({auth,quizes}) {
  const [selectedSeries,setSelectedSeries] =useState([]); // Initial
  const [seriesData,setSeriesData] =useState([]); // Initial

  useEffect(() => {
    setSelectedSeries(selectBoxKeyUpdate(quizes[0],'id','quize_name'));
  },[]);
  
useEffect(() => {
  getUserDataByQuizeId();
},[selectedSeries]);

  const getUserDataByQuizeId = () => {
    QuizeService.getUserDataByQuizeId(selectedSeries).then(response => {
        if(response.data.code == 200){
          setSeriesData(response.data.result);
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
  
  

const getOption = () => {

  return {
    title: {
      text: 'Quize Result'
    },
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow'
      }
    },
    legend: {},
    grid: {
      left: '3%',
      right: '4%',
      bottom: '3%',
      containLabel: true
    },
    xAxis: {
      type: 'value',
      boundaryGap: [0,0.01]
    },
    yAxis: {
      type: 'category',
      data: seriesData?.['quize_' + selectedSeries.value]?.users,
    },
    series: [{
      type: 'bar',
      data: seriesData?.['quize_'+selectedSeries.value]?.result,
    },
    ]
  };
}

  // Handler for select box change event
  const handleSelectChange = (data) => {
    setSelectedSeries(data);
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
      >
            <Head title="Dashboard" />
            
            <div className="form-group">
              <lable>Quizes</lable>
              <Select
                options={selectBoxKeyUpdate(quizes,'id','quize_name')}
                value={selectedSeries}
                onChange={handleSelectChange}
              />
            </div>
            <h6>Total Question :
            {seriesData?.['quize_'+selectedSeries.value]?.questions_count} </h6>
          <ReactECharts option={getOption()} />
        </AuthenticatedLayout>
  );
}