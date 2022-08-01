@extends('company.app')

@section('title' , 'Company Panel Home')

@push('scripts')
    <script>
        var delivered = Number("{{ $data['delivered_orders'] }}"),
            canceled = Number("{{ $data['canceled_orders'] }}"),
            inProgress = Number("{{ $data['in_progress_orders'] }}"),
            deliveredString = "{{ __('messages.delivered') }}",
            canceledString = "{{ __('messages.canceled') }}",
            inProgressString = "{{ __('messages.in_prog') }}",
            totalString = "{{ __('messages.total') }}",
            totalValue = "{{ $data['total_value'] }}"
            
        var options = {
            chart: {
                type: 'donut',
                width: 380
            },
            colors: ['#5c1ac3', '#e2a03f', '#e7515a'],
            dataLabels: {
              enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
                markers: {
                  width: 10,
                  height: 10,
                },
                itemMargin: {
                  horizontal: 0,
                  vertical: 8
                }
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '65%',
                  background: 'transparent',
                  labels: {
                    show: true,
                    name: {
                      show: true,
                      fontSize: '16px',
                      fontFamily: 'Nunito, sans-serif',
                      color: undefined,
                      offsetY: -10
                    },
                    value: {
                      show: true,
                      fontSize: '20px',
                      fontFamily: 'Nunito, sans-serif',
                      color: '20',
                      offsetY: 16,
                      formatter: function (val) {
                        return val
                      }
                    },
                    total: {
                      show: true,
                      showAlways: true,
                      label: totalString,
                      fontSize: '16px',
                      color: '#888ea8',
                      formatter: function (w) {
                        return w.globals.seriesTotals.reduce( function(a, b, c) {
                          return totalValue
                        }, 0)
                      }
                    }
                  }
                }
              }
            },
            stroke: {
              show: true,
              width: 15,
            },
            series: [delivered, inProgress, canceled],
            labels: [deliveredString, inProgressString, canceledString],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '400px',
                        height: '400px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
        
                breakpoint: 1439,
                options: {
                    chart: {
                        width: '390px',
                        height: '390px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                      pie: {
                        donut: {
                          size: '65%',
                        }
                      }
                    }
                },
            }]
        }
        /*
            =================================
                Sales By Category | Render
            =================================
        */
        var chart = new ApexCharts(
            document.querySelector("#chart-2"),
            options
        );
        chart.render();
        /*
    ==================================
        Sales By Category | Options
    ==================================
*/


var     janArr = ["{{ $data['canceled_orders_arr'][1] }}", "{{ $data['completed_orders_arr'][1] }}", "{{ $data['Inprogress_orders_arr'][1] }}"],
        febArr = ["{{ $data['canceled_orders_arr'][2] }}", "{{ $data['completed_orders_arr'][2] }}", "{{ $data['Inprogress_orders_arr'][2] }}"],
        marArr = ["{{ $data['canceled_orders_arr'][3] }}", "{{ $data['completed_orders_arr'][3] }}", "{{ $data['Inprogress_orders_arr'][3] }}"],
        abrArr = ["{{ $data['canceled_orders_arr'][4] }}", "{{ $data['completed_orders_arr'][4] }}", "{{ $data['Inprogress_orders_arr'][4] }}"],
        mayArr = ["{{ $data['canceled_orders_arr'][5] }}", "{{ $data['completed_orders_arr'][5] }}", "{{ $data['Inprogress_orders_arr'][5] }}"],
        junArr = ["{{ $data['canceled_orders_arr'][6] }}", "{{ $data['completed_orders_arr'][6] }}", "{{ $data['Inprogress_orders_arr'][6] }}"],
        julArr = ["{{ $data['canceled_orders_arr'][7] }}", "{{ $data['completed_orders_arr'][7] }}", "{{ $data['Inprogress_orders_arr'][7] }}"],
        augArr = ["{{ $data['canceled_orders_arr'][8] }}", "{{ $data['completed_orders_arr'][8] }}", "{{ $data['Inprogress_orders_arr'][8] }}"],
        sepArr = ["{{ $data['canceled_orders_arr'][9] }}", "{{ $data['completed_orders_arr'][9] }}", "{{ $data['Inprogress_orders_arr'][9] }}"],
        octArr = ["{{ $data['canceled_orders_arr'][10] }}", "{{ $data['completed_orders_arr'][10] }}", "{{ $data['Inprogress_orders_arr'][10] }}"],
        novArr = ["{{ $data['canceled_orders_arr'][11] }}", "{{ $data['completed_orders_arr'][11] }}", "{{ $data['Inprogress_orders_arr'][11] }}"],
        decArr = ["{{ $data['canceled_orders_arr'][12] }}", "{{ $data['completed_orders_arr'][12] }}", "{{ $data['Inprogress_orders_arr'][12] }}"],
        jan = "{{ __('messages.jan') }}",
        feb = "{{ __('messages.feb') }}",
        mar = "{{ __('messages.mar') }}",
        apr = "{{ __('messages.apr') }}",
        may = "{{ __('messages.may') }}",
        jun = "{{ __('messages.jun') }}",
        jul = "{{ __('messages.jul') }}",
        aug = "{{ __('messages.aug') }}",
        sep = "{{ __('messages.sep') }}",
        oct = "{{ __('messages.oct') }}",
        nov = "{{ __('messages.nov') }}",
        dec = "{{ __('messages.dec') }}",
        totalProfit = "{{ $data['delivered_orders_cost'] }}",
        totalProfitString = "{{ __('messages.total_profit') }}",
        dinar = "{{ __('messages.dinar') }}"



/*
    =================================
        Revenue Monthly | Options
    =================================
*/
var options1 = {
    chart: {
      fontFamily: 'Nunito, sans-serif',
      height: 365,
      type: 'area',
      zoom: {
          enabled: false
      },
      dropShadow: {
        enabled: true,
        opacity: 0.3,
        blur: 5,
        left: -7,
        top: 22
      },
      toolbar: {
        show: false
      },
      events: {
        mounted: function(ctx, config) {
          const highest1 = ctx.getHighestValueInSeries(0);
          const highest2 = ctx.getHighestValueInSeries(1);
          const highest3 = ctx.getHighestValueInSeries(2);
  
          ctx.addPointAnnotation({
            x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
            y: highest1,
            label: {
              style: {
                cssClass: 'd-none'
              }
            },
            customSVG: {
                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                cssClass: undefined,
                offsetX: -8,
                offsetY: 5
            }
          })
  
          ctx.addPointAnnotation({
            x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
            y: highest2,
            label: {
              style: {
                cssClass: 'd-none'
              }
            },
            customSVG: {
                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                cssClass: undefined,
                offsetX: -8,
                offsetY: 5
            }
          })

          ctx.addPointAnnotation({
            x: new Date(ctx.w.globals.seriesX[2][ctx.w.globals.series[2].indexOf(highest3)]).getTime(),
            y: highest3,
            label: {
              style: {
                cssClass: 'd-none'
              }
            },
            customSVG: {
                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#bb8332" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                cssClass: undefined,
                offsetX: -8,
                offsetY: 5
            }
          })
        },
      }
    },
    colors: ['#1b55e2', '#e7515a', '#bb8332'],
    dataLabels: {
        enabled: false
    },
    markers: {
      discrete: [{
      seriesIndex: 0,
      dataPointIndex: 7,
      fillColor: '#000',
      strokeColor: '#000',
      size: 5
    }, {
      seriesIndex: 2,
      dataPointIndex: 11,
      fillColor: '#000',
      strokeColor: '#000',
      size: 4
    }, {
        seriesIndex: 4,
        dataPointIndex: 15,
        fillColor: '#000',
        strokeColor: '#000',
        size: 3
      }]
    },
    subtitle: {
      text: totalProfitString,
      align: 'center',
      margin: 25,
      
      floating: false,
      style: {
        fontSize: '14px',
        color:  '#888ea8'
      }
    },
    title: {
      text: `${totalProfit} ${dinar}`,
      align: 'center',
      margin: 0,
      
      floating: false,
      style: {
        fontSize: '25px',
        color:  '#0e1726'
      },
    },
    stroke: {
        show: true,
        curve: 'smooth',
        width: 2,
        lineCap: 'square'
    },
    series: [{
        name: deliveredString,
        data: [Number(janArr[1]), Number(febArr[1]), Number(marArr[1]), Number(abrArr[1]), Number(mayArr[1]), Number(junArr[1]), Number(julArr[1]), Number(augArr[1]), Number(sepArr[1]), Number(octArr[1]), Number(novArr[1]), Number(decArr[1])]
    },
    {
        name: canceledString,
        data: [Number(janArr[0]), Number(febArr[0]), Number(marArr[0]), Number(abrArr[0]), Number(mayArr[0]), Number(junArr[0]), Number(julArr[0]), Number(augArr[0]), Number(sepArr[0]), Number(octArr[0]), Number(novArr[0]), Number(decArr[0])]
    },
    {
        name: inProgressString,
        data: [Number(janArr[2]), Number(febArr[2]), Number(marArr[2]), Number(abrArr[2]), Number(mayArr[2]), Number(junArr[2]), Number(julArr[2]), Number(augArr[2]), Number(sepArr[2]), Number(octArr[2]), Number(novArr[2]), Number(decArr[2])]
    }],
    labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
    xaxis: {
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      crosshairs: {
        show: true
      },
      labels: {
        offsetX: 0,
        offsetY: 5,
        style: {
            fontSize: '12px',
            fontFamily: 'Nunito, sans-serif',
            cssClass: 'apexcharts-xaxis-title',
        },
      }
    },
    yaxis: {
      labels: {
        formatter: function(value, index) {
          return value
        },
        offsetX: -22,
        offsetY: 0,
        style: {
            fontSize: '12px',
            fontFamily: 'Nunito, sans-serif',
            cssClass: 'apexcharts-yaxis-title',
        },
      }
    },
    grid: {
      borderColor: '#e0e6ed',
      strokeDashArray: 5,
      xaxis: {
          lines: {
              show: true
          }
      },   
      yaxis: {
          lines: {
              show: false,
          }
      },
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: -10
      }, 
    }, 
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      offsetY: -50,
      fontSize: '16px',
      fontFamily: 'Nunito, sans-serif',
      markers: {
        width: 10,
        height: 10,
        strokeWidth: 0,
        strokeColor: '#fff',
        fillColors: undefined,
        radius: 12,
        onClick: undefined,
        offsetX: 0,
        offsetY: 0
      },    
      itemMargin: {
        horizontal: 0,
        vertical: 20
      }
    },
    tooltip: {
      theme: 'dark',
      marker: {
        show: true,
      },
      x: {
        show: false,
      }
    },
    fill: {
        type:"gradient",
        gradient: {
            type: "vertical",
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .28,
            opacityTo: .05,
            stops: [45, 100]
        }
    },
    responsive: [{
      breakpoint: 575,
      options: {
        legend: {
            offsetY: -30,
        },
      },
    }]
  }

  /*
    ================================
        Revenue Monthly | Render
    ================================
*/
var chart1 = new ApexCharts(
    document.querySelector("#revenueMonthly"),
    options1
);

chart1.render();

    </script>
@endpush

@section('content')
<div class="row" >
    <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h5 class="">{{ __('messages.orders')}}</h5>
                <ul class="tabs tab-pills">
                    <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">{{ __('messages.Monthly') }}</a></li>
                </ul>
            </div>

            <div class="widget-content">
                <div class="tabs tab-content">
                    <div id="content_1" class="tabcontent"> 
                        <div id="revenueMonthly"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-two">
            <div class="widget-heading">
                <h5 class="">{{ __('messages.orders') }}</h5>
            </div>
            <div class="widget-content">
                <div id="chart-2" class=""></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-table-two">

            <div class="widget-heading">
                <h5 class="">{{ __('messages.recent_orders') }}</h5>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><div class="th-content">{{ __('messages.order_number') }}</div></th>
                                <th><div class="th-content">{{ __('messages.order_date') }}</div></th>
                                <th><div class="th-content">{{ __('messages.user') }}</div></th>
                                <th><div class="th-content th-heading">{{ __('messages.total_with_delivery') }}</div></th>
                                <th><div class="th-content th-heading">{{ __('messages.status') }}</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['recent_orders'] as $recent_order)
                            
                            <tr>
                                <td><div class="td-content"><a href="{{ route('orders.company.invoice', $recent_order->id) }}?download=1" >{{ $recent_order->order_number }}</a></div></td>
                                <td><div class="td-content product-brand">{{ $recent_order->created_at->format("d-m-y") }}</div></td>
                                <td><div class="td-content customer-name">{{ $recent_order->user->name }}</div></td>
                                @php
                                  $dcost = "0.000";
                                  if ($recent_order->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost) {
                                    $dcost = $recent_order->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost;
                                  }
                                @endphp
                                <td><div class="td-content pricing"><span class="">{{ $recent_order->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $dcost . " " . __('messages.dinar') }}</span></div></td>
                                <td>
                                  <div class="td-content">
                                    @if(in_array($recent_order->oItemCompany(Auth::user()->id)->status, [1, 2, 3]))
                                    <span class="badge outline-badge-primary">{{ __('messages.opened') }}</span>
                                    @else
                                    <span class="badge outline-badge-danger">{{ __('messages.closed') }}</span>
                                    @endif
                                  </div>
                                </td>
                            </tr>
                            
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-table-three">

            <div class="widget-heading">
                <h5 class="">{{ __('messages.top_selling_products') }}</h5>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><div class="th-content">{{ __('messages.product_title') }}</div></th>
                                <th><div class="th-content th-heading">{{ __('messages.price_before_discount') }}</div></th>
                                <th><div class="th-content th-heading">{{ __('messages.price_after_discount') }}</div></th>
                                <th><div class="th-content">{{ __('messages.sold') }}</div></th>
                                <th><div class="th-content">{{ __('messages.remaining_quantity') }}</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['most_sold_products'] as $sold_product)
                            <tr>
                                <td><div class="td-content product-name"><a href="{{ route('products.details', $sold_product->id) }}" >{{ App::isLocale('en') ? $sold_product->title_en : $sold_product->title_ar }}</a></div></td>
                                <td><div class="td-content"><span class="pricing">{{ $sold_product->multi_options == 0 ? $sold_product->price_before_offer . " " . __('messages.dinar') : $sold_product->option_price_before_offer . " " . __('messages.dinar') }}</span></div></td>
                                <td><div class="td-content"><span class="discount-pricing">{{ $sold_product->multi_options == 0 ? $sold_product->final_price . " " . __('messages.dinar') : $sold_product->option_price . " " . __('messages.dinar') }}</span></div></td>
                                <td><div class="td-content">{{ $sold_product->sold_count }}</div></td>
                                <td><div class="td-content"><a href="javascript:void(0);" class="">{{ $sold_product->remaining_quantity  }}</a></div></td>
                            </tr>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        <a href="/admin-panel/products/show?expire=soon" >
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">{{ $data['products_less_than_ten'] }}</h6>
                            <p class=""> {{ __('messages.products_less_than_ten') }}</p>
                        </div>
                        <div class="">
                            <div class="w-icon">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    

                       
@endsection

