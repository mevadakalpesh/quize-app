import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head,Link,router} from '@inertiajs/react';
import React, { useEffect, useMemo, useState } from 'react';
import { MaterialReactTable } from 'material-react-table';
import axios from 'axios';
import { Box, IconButton } from '@mui/material';
import {SendMailService} from '@/Services/Index.jsx'
import { Edit as EditIcon, Delete as DeleteIcon } from '@mui/icons-material';
import Toster from '@/Components/Toster';


function MailLists({auth,flash,templates}){
  const [data, setData] = useState(templates);
  
  function deleteTemplate(row){
      SendMailService.deleteTemplate(row.original.id).then(response => {
        if(response.data.code == 200){
            data.splice(row.index, 1); //assuming simple data table
            setData([...data]);
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
  
  function editTemplate(row){
    router.visit(route('templates.edit',row.original.id));
  }
  

  const columns = useMemo(
    () => [
      {
        accessorKey: 'subject',
        header: 'Subject',
      },
    ],
    [],
  );
    
    return (
            <div className="py-12">
                <h1>Email Templates</h1>
                <Link as="button" className="btn btn-info" href={route('templates.create')}>Add Template</Link>
                <Link as="button" className="btn btn-info mx-3 my-2" href={route('template.sendMail')}>Send Mail</Link>
                
                <MaterialReactTable
                  columns={columns}
                  enableRowActions
                  renderRowActions={({ row, table }) => (
                    <Box sx={{ display: 'flex', flexWrap: 'nowrap', gap: '8px' }}>
                      <IconButton
                        color="secondary"
                        onClick={() => editTemplate(row)}
                      >
                        <EditIcon />
                      </IconButton>
                      <IconButton
                        color="error"
                        onClick={() => deleteTemplate(row) }
                      >
                        <DeleteIcon />
                      </IconButton>
                    </Box>
                  )}
                  data={data}
                  enableRowSelection
                  getRowId={(row) => row.phoneNumber}
                  manualFiltering
                  manualPagination
                  manualSorting
                />
                 <Toster flash={flash} />
            </div>
      
    );
}

MailLists.layout = page => <AuthenticatedLayout children={page} title="Dashboard"  />

export default MailLists;