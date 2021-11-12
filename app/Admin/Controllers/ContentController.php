<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Content;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ContentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Content(), function (Grid $grid) {
            $grid->column('id')->sortable();
//            $grid->column('language');
//            $grid->column('content');
            $grid->column('password');
            $grid->column('count_limit');
            $grid->column('time_limit');
            $grid->column('is_destroy');
//            $grid->column('user_id');
            $grid->column('ip');
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Content(), function (Show $show) {
            $show->field('id');
            $show->field('language');
            $show->field('content');
            $show->field('password');
            $show->field('count_limit');
            $show->field('time_limit');
            $show->field('is_destroy');
            $show->field('user_id');
            $show->field('ip');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Content(), function (Form $form) {
            $form->display('id');
            $form->text('language');
            $form->text('content');
            $form->text('password');
            $form->text('count_limit');
            $form->text('time_limit');
            $form->text('is_destroy');
            $form->text('user_id');
            $form->text('ip');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
