<?php

/**
 * 分页结果对象
 * @author auto create
 */
class PageQueryCursorResult
{
	
	/** 
	 * 是否有更多数据
	 **/
	public $has_more;
	
	/** 
	 * 下一次分页的游标
	 **/
	public $next_cursor;
	
	/** 
	 * 工单列表
	 **/
	public $ticket_list;
	
	/** 
	 * 总数
	 **/
	public $total;	
}
?>