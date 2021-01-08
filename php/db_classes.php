<?php
	
	class account extends MyActiveRecord{}
	class account_globals extends MyActiveRecord{

		function getvalue($account_id, $name)
		{
			$row = MyActiveRecord::FindFirst('account_globals', array("account_id"=>$account_id, "name"=>$name));
			return $row->value;
		}
	}

	class account_user extends MyActiveRecord{}	
	class account_user_logs extends MyActiveRecord{}
	class account_user_notification extends MyActiveRecord{}

	class account_giftcard extends MyActiveRecord{}
	class account_purchase extends MyActiveRecord{

		// Build query for extracting data for ajax listing
		function build_query($params, $in_count_mode = 0) {

			// Init conditions & joins
			$add_cond = array();
			$add_join = array();

			$add_cond[] = "account_purchase.account_id = " . MyActiveRecord::Escape($_SESSION['user']['account_id']);
		
			// Add search conditions
			if (isset($params['search']) && !empty($params['search']))
			{
				$add_cond_where = array();
				foreach($params['search'] as $field=>$val)
				{
					if ($val != "")
					{
						if ($field == "client")
						{
							$add_cond_where[] = "(code LIKE " . MyActiveRecord::Escape("%" . $val . "%") . " OR receiver_name LIKE " . MyActiveRecord::Escape("%" . $val . "%") . " OR receiver_email LIKE " . MyActiveRecord::Escape("%" . $val . "%") . ")";
						}
						elseif ($field == "account_giftcard_id")
						{
							$add_cond_where[] = "account_giftcard_id = " . MyActiveRecord::Escape($val);
						}
						elseif ($field == "payment_status")
						{
							$add_cond_where[] = "payment_status = " . MyActiveRecord::Escape($val);
						}
						elseif ($field == "sent_status")
						{
							$add_cond_where[] = "sent_status = " . MyActiveRecord::Escape($val);
						}
						elseif ($field == "redeemed")
						{
							$add_cond_where[] = "redeemed = " . MyActiveRecord::Escape($val);
						}
						elseif ($field == "added_on")
						{
							$start_interval = $end_interval = "";
							$daterangepicker_data = explode("-", $val);
							$start_interval = trim($daterangepicker_data[0]);
				            $end_interval = trim($daterangepicker_data[1]);
				            if ($start_interval != "") {
				                $add_cond_where[] = "DATE_FORMAT(added_on, '%Y-%m-%d') >= '" . date_format(date_create_from_format('m/d/Y', $start_interval), 'Y-m-d') . "'";
				            }
				            if ($end_interval != "") {
				                $add_cond_where[] = "DATE_FORMAT(added_on, '%Y-%m-%d') <= '" . date_format(date_create_from_format('m/d/Y', $end_interval), 'Y-m-d') . "'";
				            }
						}
						else
						{
							$add_cond_where[] = "LOWER(" . $field . ") LIKE " . MyActiveRecord::Escape("%" . strtolower($val) . "%");
						}
					}
				}
				if (sizeof($add_cond_where) > 0)
				{
					$add_cond[] = "((" . join(") AND (", $add_cond_where) . "))";
				}
			}
			
			// Set fields depending on query type
			$fields_part = array();
			if ($in_count_mode)
			{
				$fields_part[] = "COUNT(*) AS cnter";
			}
			else
			{
				$fields_part[] = "account_purchase.*, (SELECT account_giftcard.name FROM account_giftcard WHERE account_purchase.account_giftcard_id = account_giftcard.id) AS giftcard_name";				
			}
			$fields = join(", ", $fields_part);
			
			// Init query
			$full_query = "SELECT " . $fields . " FROM account_purchase";
			// Add joins
			if (sizeof($add_join) > 0) {
				$full_query .= " " . join(" ", $add_join);
			}

			// Add search conditions
			if (sizeof($add_cond) > 0) {
				$full_query .= " WHERE " . join(" AND ", $add_cond);
			}

			// Build order conditions 
			$order_by = "";
			if (isset($params['order_by']) && sizeof($params['order_by']) > 0)
			{
				$order_by = " ORDER BY " . join(", ", $params['order_by']);
			}
			
			// Build limit
			$limit = "";
			if (isset($params['start']) && isset($params['length']))
			{
				$limit = " LIMIT " . $params['start'] . ', ' . $params['length'];
			}	
			
			// Add order and limit, but not in count mode
			$full_query_all = $full_query
			. (!$in_count_mode ? $order_by : "") 
			. (!$in_count_mode ? $limit : "");

			return $full_query_all;
		}

		function get_list($params)
		{
			
			// Get the total number of records
			$full_query_all_count = self::build_query($params, 1);
			$rec = mysqli_fetch_assoc(MyActiveRecord::Query($full_query_all_count));
			$total_rows = $rec['cnter'];

			// Get the records
			$full_query_all = self::build_query($params);
			$items = MyActiveRecord::FindBySql("account_purchase", $full_query_all);

			// Process records	
			$row_data = array();
			if(!empty($items))
			{
				
				foreach ($items as $item) 
				{
					$this_row = array();
			
					$this_row[] = "<strong>" . $item->id . "</strong>";
					$this_row[] = "<strong>" . $item->giftcard_name .  "</strong><br/>" . $item->benefits;
					$this_row[] = "<strong>" . $item->receiver_name . "</strong><br/><a href=\"mailto:" . $item->receiver_email . "\">" . $item->receiver_email . "</a><br/>" . "Code: " . $item->receiver_code;

					
					$this_row[] = "$" . number_format($item->price_total, 2);

					$payment_info = ($item->payment_gateway) != "" ? "<span class=\"label bg-blue\">" . strtoupper($item->payment_gateway) . "</span></br>" : "";
					$payment_info .= (($item->payment_status == "paid" ? "<span class=\"label bg-green\">PAID</span>" : (($item->payment_status == "rejected") ? "<span class=\"label bg-red\">REJECTED</span>" : "<span class=\"label bg-red\">NOT PAID</span>")));
					$this_row[] = $payment_info;

					$this_row[] = ($item->sent_status == "sent" ? "<span class=\"label bg-green\">SENT</span>" : ($item->sent_status == "error" ? "<span class=\"label bg-red\">ERROR</span>" : "<span class=\"label bg-yellow\">QUEUED</span>"));

					$this_row[] = "<input type=\"checkbox\" " . ($item->redeemed == "on" ? "checked" : "") . " data-toggle=\"toggle\" class=\"toggle-status\" data-on=\"Yes\" data-onstyle=\"success\" data-off=\"No\" data-size=\"mini\" id=\"redeemed_" . $item->id . "\" data-status=\"" . $item->redeemed . "\">";
					$this_row[] = date("m/d/Y g:i A", strtotime($item->added_on));
					
					$row_data[] = $this_row;

				}
			}
			
			// Return records
			return array("row_data"=>$row_data, "row_total"=>$total_rows);
			
		}
	}
	
	class globals extends MyActiveRecord{

		function getvalue($name)
		{
			$row = MyActiveRecord::FindFirst('globals', array("name"=>$name));
			return $row->value;
		}
	}	

	class category extends MyActiveRecord{}
	class giftcard extends MyActiveRecord{}

?>