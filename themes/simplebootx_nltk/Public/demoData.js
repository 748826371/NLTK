	 		$(function(){
	 			/* 新闻数据模板 */
	 			var news = [
	 				{coll_id: 6, object_id: 241},
	 				{coll_id: 6, object_id: 241},
	 				{coll_id: 6, object_id: 241}
	 			];
	 			function plotData(scope) {
		 			/* 高校配置ID */
			 		var coll = [
							'',
							'武汉大学',
							'北京大学',
							'中国人民大学',
							'南京大学',
							'中山大学',
							'华中师范大学'
						];
					var data = [];
					/*
						[coll_name, count]
					*/
					var hashArr = [];
		 			for(var item in scope) {
		 				var coll_name = item[item.coll_id] ? item[item.coll_id] : false;
		 				if(!coll_name) {
		 					alert('系统传出的数据有误,刷新页面');
		 					return false;
		 				}
		 				// 统计
		 				var flag = false;
		 				for (var i = 0; i < hashArr.length; i++) {
		 					var h = hashArr[i];
		 					if(coll_name === h[0]){
		 						hashArr[i][1]++;
		 						flag = true;
		 					}	 						
		 				};
		 				// 没有找到
		 				if(!flag) {
			 				var temp = [];
			 				temp.push(coll_name);	
			 				temp.push(1); 				
			 				hashArr.push(temp);
		 				}
		 			}
		 			return hashArr;
	 			}

			}); 
			  
		});	
	var Plot = {
		coll_id:  [
					'',  // 0
					'武汉大学',
					'北京大学',
					'中国人民大学',
					'南京大学',
					'中山大学',
					'华中师范大学'
				  ],
		groupCount: function(scope) {
			var res = []; // 最后返回的数组
			var obj = {}; // 存入数组中的JSON
			var hash = []; // 存放的统计 
			/*
				大学名称 => 次数
				['武汉大学' => 6, ]
			*/
			for(i in scope) { // 遍历数组
				var temp_id = scope[i].coll_id;
				var coll_name = coll[temp_id];
				// 统计搜索的个数
				if(hash.indexOf(temp_id) == -1){ // 首次出现
					hash.coll_name = 1;
				}else{ // 不是第一次出现 需要查找并统计
					for(j in hash) {						
						if(coll_name == j)
							hash[j]++;
					}
				}
			}
			for(var item in hash) { // 遍历hash表
				obj.label = item;
				obj.data = hash[item];
				res.push(obj);
				obj = {};
			}
			console.log(res);
		},
		pie: function($area, data){ // 绘图
			$.plot($area, data, {  
				series: {  
					pie: {   
						show: true //显示饼图  
					}  
				},  
				legend: {  
					show: false //不显示图例  
				}  
			}); 
		}
	};