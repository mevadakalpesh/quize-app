import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head,Link,router} from '@inertiajs/react';
import React, { useEffect, useMemo, useState } from 'react';
import { MaterialReactTable } from 'material-react-table';
import axios from 'axios';
import { Box, IconButton } from '@mui/material';
import {QuizeService} from '@/Services/Index.jsx'
import { Edit as EditIcon, Delete as DeleteIcon } from '@mui/icons-material';
import Toster from '@/Components/Toster';


function QuizeListing({auth,flash}){
  const [data, setData] = useState([]);
  const [isError, setIsError] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [isRefetching, setIsRefetching] = useState(false);
  const [rowCount, setRowCount] = useState(0);

  //table state
  const [columnFilters, setColumnFilters] = useState([]);
  const [globalFilter, setGlobalFilter] = useState('');
  const [sorting, setSorting] = useState([]);
  const [pagination, setPagination] = useState({
    pageIndex: 0,
    pageSize: 10,
  });
  
  function deleteQuize(row){
      QuizeService.deleteQuize(row.original.id).then(response => {
        if(response.data.code == 200){
         getDataWithFilter();
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
  
  function editQuize(row){
    router.visit(route('quize.edit',row.original.id));
  }
  
 const getDataWithFilter = () => {
      if (!data.length) {
        setIsLoading(true);
      } else {
        setIsRefetching(true);
      }
      let filter = {
          'start' : `${pagination.pageIndex * pagination.pageSize}`,
          'size' : `${pagination.pageSize}`,
          'filters' : JSON.stringify(columnFilters ?? []),
          'globalFilter' : globalFilter ?? '',
          'sorting' : JSON.stringify(sorting ?? [])
        };
      QuizeService.getQuizes(filter).then(response => {
        if(response.data.code == 200){
         setData(response.data.result.quizes);
         setRowCount(response.data.result.quizes_count);
        }
      })
      .catch(error => {
        console.error(error);
      });
      setIsError(false);
      setIsLoading(false);
      setIsRefetching(false);
  }
useEffect(() => {
    getDataWithFilter();
},[
    columnFilters,
    globalFilter,
    pagination.pageIndex,
    pagination.pageSize,
    sorting,
  ]);
  

  const columns = useMemo(
    () => [
      {
        accessorKey: 'quize_name',
        header: 'Quize',
      },
      {
        accessorKey: 'description',
        header: 'Description',
      },
      {
        accessorKey: 'status',
        header: 'Status',
        Cell: ({ cell, row }) => (
          <span className={(row.original?.status) == 'Active' ? 'badge badge-success'
          : 'badge badge-danger'}>{row.original?.status }</span>
        ),
      },
      {
        accessorKey: 'expire_time',
        header: 'Expire Time',
      },
      {
        accessorKey: 'link',
        header: 'Link',
      },
      {
        accessorKey: 'quize_status',
        header: 'Quize Status',
      },
    ],
    [],
  );
    
    return (
            <div className="py-12">
                <h1>Quize List</h1>
                <Link as="button" className="btn btn-info" href={route('quize.create')}>Add Quize</Link>
                <MaterialReactTable
      columns={columns}
      enableRowActions
      renderRowActions={({ row, table }) => (
        <Box sx={{ display: 'flex', flexWrap: 'nowrap', gap: '8px' }}>
          <IconButton
            color="secondary"
            onClick={() => editQuize(row)}
          >
            <EditIcon />
          </IconButton>
          <IconButton
            color="error"
            onClick={() => deleteQuize(row) }
          >
            <DeleteIcon />
          </IconButton>
        </Box>
      )}
      data={data}
      enableRowSelection
      getRowId={(row) => row.phoneNumber}
      initialState={{ showColumnFilters: true }}
      manualFiltering
      manualPagination
      manualSorting
      muiToolbarAlertBannerProps={
        isError
          ? {
              color: 'error',
              children: 'Error loading data',
            }
          : undefined
      }
      onColumnFiltersChange={setColumnFilters}
      onGlobalFilterChange={setGlobalFilter}
      onPaginationChange={setPagination}
      onSortingChange={setSorting}
      rowCount={rowCount}
      state={{
        columnFilters,
        globalFilter,
        isLoading,
        pagination,
        showAlertBanner: isError,
        showProgressBars: isRefetching,
        sorting,
      }}
    />
    <Toster flash={flash} />
            </div>
      
    );
}

QuizeListing.layout = page => <AuthenticatedLayout children={page} title="Dashboard"  />

export default QuizeListing;