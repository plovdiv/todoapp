<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use App\TaskList;
use App\Task;

class TaskListsService
{

    /**
     * Generate Tasks  export document from list
     * @param TaskList $taskList
     * @param string $format
     *
     * @return \Maatwebsite\Excel\LaravelExcelWriter
     */
    public function export(TaskList $taskList, $format = 'xls')
    {
        $document = Excel::create('todolist-export-tasks-' . Carbon::now(), function (LaravelExcelWriter $excel) use ($taskList) {

                    $excel->sheet('sheet', function (LaravelExcelWorksheet $sheet) use ($taskList) {

                        //add header row
                        $sheet->appendRow(array_keys(Task::XLS_ATTRIBUTE_MAP));

                        //Add a row in the document for each task
                        $taskList->tasks()->chunk(5, function (Collection $tasks) use ($sheet) {

                            $tasks->each(function (Task $task) use ($sheet) {

                                $rowData = collect($task)
                                        ->only(Task::XLS_ATTRIBUTE_MAP)
                                        ->all();
                                $sheet->appendRow($rowData);
                            });
                        });
                    });
                })->export($format);

        return $document;
    }

}
