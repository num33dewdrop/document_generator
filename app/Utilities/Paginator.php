<?php

namespace App\Utilities;

use App\Http\Requests\Request;

class Paginator {
	private int $totalPage;
	private int $currentPage;
	private int $pageCol;
	private Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function setPage($currentPage, $totalPage, $pageCol = 5 ): Paginator {
		$this->totalPage = $totalPage;
		$this->currentPage = $currentPage;
		$this->pageCol = $pageCol;
		return $this;
	}

	public function getRequest(): Request {
		return $this->request;
	}

	public function links(): string {
		$links = '';
		if ( $this->pageCol <= 1 ) {
			$minPage = $this->currentPage;
			$maxPage = $this->currentPage;
		} elseif ( $this->pageCol < $this->totalPage ) {
			if ( $this->currentPage < ceil( $this->pageCol / 2 ) ) {
				$minPage = 1;
				$maxPage = $this->pageCol;
			} elseif ( $this->currentPage < $this->totalPage - floor( $this->pageCol / 2 ) ) {
				$maxPage = $this->currentPage + floor( $this->pageCol / 2 );
				$minPage = $maxPage - ( $this->pageCol - 1 );
			} else {
				$maxPage = $this->totalPage;
				$minPage = $maxPage - ( $this->pageCol - 1 );
			}
		} else {
			$minPage = 1;
			$maxPage = $this->totalPage;
		}

		if ( $this->currentPage !== 1 ) {
			$links .= '<li><a href="'.appendGetParam($this->request->getAll(), array('p'), array('p'=>1)).'" class="c-pager__link"><svg width="10" height="10" xmlns="http://www.w3.org/2000/svg"><use href="'.assets('img/symbol/arrow.svg#first').'"></use></svg></a></li>';
			$links .= '<li><a href="'.appendGetParam($this->request->getAll(), array('p'), array('p'=>$this->currentPage-1)).'" class="c-pager__link"><svg width="10" height="10" xmlns="http://www.w3.org/2000/svg"><use href="'.assets('img/symbol/arrow.svg#prev').'"></use></svg></a></li>';
		}

		if (! empty( $this->pageCol ) ) {
			for ( $i = $minPage; $i <= $maxPage; $i ++ ) {
				$useClass = ($this->currentPage === (int)$i)? ' c-pager__link--active': '';
				$links .= '<li><a href="'.appendGetParam($this->request->getAll(), array('p'), array('p'=>$i)).'" class="c-pager__link'.$useClass.'">'.$i.'</a></li>';
			}
		}

		if ( ! empty($this->totalPage) && $this->currentPage !== $this->totalPage ) {
			$links .= '<li><a href="'.appendGetParam($this->request->getAll(), array('p'), array('p'=>$this->currentPage+1)).'" class="c-pager__link"><svg width="10" height="10" xmlns="http://www.w3.org/2000/svg"><use href="'.assets('img/symbol/arrow.svg#next').'"></use></svg></a></li>';
			$links .= '<li><a href="'.appendGetParam($this->request->getAll(), array('p'), array('p'=>$this->totalPage)).'" class="c-pager__link"><svg width="10" height="10" xmlns="http://www.w3.org/2000/svg"><use href="'.assets('img/symbol/arrow.svg#last').'"></use></svg></a></li>';
		}
		return $links;
	}
}