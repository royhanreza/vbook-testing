<!doctype html>
<html lang="en">

<head>
    @php
    \Carbon\Carbon::setLocale('id')
    @endphp
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>VBOOK </title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .blinking {
            animation: blinkingText 1.2s infinite;
        }

        @keyframes blinkingText {
            0% {
                color: #fff;
            }

            49% {
                color: #fff;
            }

            60% {
                color: transparent;
            }

            99% {
                color: transparent;
            }

            100% {
                color: #fff;
            }
        }

        #reader video {
            width: 100% !important;
        }

        #rcorners2 {
            border-radius: 15px 50px 30px 5px;
            border: 2px solid #ff461f;
            padding: 10px;
            width: 350px;
            height: 75px;
        }


        #rcorners3 {
            border-radius: 15px 50px 30px 5px;
            border: 2px solid #ff461f;
            padding: 10px;
            width: 340px;
            height: 50px;
        }

        .opacity {
            background: 100%;
            height: auto;
            background: #00000078;
        }

        .qr-code-fly {
            background: white;
            width: 133px;
            display: none;
            padding: 10px;
        }

        .font-space {
            font-family: 'Space Mono', monospace;
        }

        .background-display {
            background-image: url('{{ asset("/assets/booking-room/images/background-display.png") }}');
            background-position: left;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
        }

        .garis-led {
            margin-top: 0vh;
            margin-bottom: 0vh;
            /* border: 11px solid #F31111; */


            border-radius: 14vw;
            height: 92vh;
            width: 1px;
            transform: rotate(180deg);

        }

        .info-card {
            background-color: #303030;
            border-radius: 15px;
        }

        /* .circle {
        border: 2px solid red;
        height: 100px;
        border-radius:50%;
        width: 100px;
      } */

        .text-title {
            font-size: 4rem;
            color: #F31111;
        }

        .centered {
            position: absolute;
            top: 9%;
            width: 130px;
        }

        .progres {
            position: relative;
            margin: 4px;
            float: left;
            text-align: center;
        }

        .scrollbar {
            float: left;
            overflow-y: scroll;
            height: 40px;
        }

        #style-1::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        #style-1::-webkit-scrollbar {
            width: 4px;
        }

        #style-1::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }

        .barOverflow {
            /* Wraps the rotating .bar */
            position: relative;
            /* overflow: hidden; Comment this line to understand the trick */
            width: 272px;
            height: 136px;
            /* Half circle (overflow) */
            margin-bottom: -14px;
            /* bring the numbers up */
        }

        .bar {
            position: absolute;
            /* bottom: 0; */
            /* left: 0; */
            width: 225px;
            height: 225px;
            border-radius: 50%;
            box-sizing: border-box;
        }

        .style-after-upcoming {
            position: absolute;
            z-index: 99;
            bottom: 74px;
            right: 100px;
        }
    </style>
</head>
<!-- Modal -->

<body class="background-display">
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-md-1 px-4 py-3">
                <hr class="garis-led" style="background-color: <?= $lineColor ?>; border: 11px solid <?= $lineColor ?>;">
            </div>
            <div class="col-md-5 p-0 py-3 ">
                <div style="height: 38vh;">
                    <!-- <div class="circle"></div> -->
                    <div class="progre">
                        <div class="barOverflo">
                            <div class="bar" style="transform: rotate(405deg); border: 10px solid <?= $lineColor ?>; border-bottom-color: <?= $lineColor ?>; border-right-color: <?= $lineColor ?>;"></div>
                        </div>
                    </div>
                </div>
                <br>
                @if ($bookingOngoing->count() > 0)
                <h4>
                    <div class="centered mx-5 text-center text-white py-5" id="getCountdown">
                    </div>
                </h4>
                @else
                <div class="centered mx-5 text-center text-white py-4">
                    Tidak ada meeting yang berlangsung
                </div>

                @endif


                <h4 class="m-0 font-weight-normal text-white">Room - {{ auth()->user()->name }}
                </h4>
                <span class="badge badge-secondary m-0 font-weight-normal text-white">IP Address - {{ $ip }}</span>
                <div id="meetingOnProgress">

                </div>
                <div id="getNextMeeting">
                </div>

                <div class="d-flex mt-3 ">
                    <div class="mr-3 mb-2">
                        <div class="card-body text-white text-center info-card">
                            <h1 class="font-weight-normal m-0 mb-3">
                                {{ auth()->user()->room->kapasitas }} <i class="fas fa-user-friends"></i>
                            </h1>
                            <h5 class="font-weight-normal m-0 ">{{ auth()->user()->room->capacity }} orang </h5>
                        </div>
                    </div>
                    @if (auth()->user()->room->projector == 1)
                    <div class="mr-3 mb-2">
                        <div class="card-body text-white text-center info-card">
                            <h1 class="font-weight-normal m-0 mb-3"><i class="fas fa-tv"></i></h1>
                            <h5 class="font-weight-normal m-0 ">Proyektor</h5>
                        </div>
                    </div>
                    @endif
                    @if (auth()->guard('web')->user()->room->internet == 1)
                    <div class="mr-3 mb-2">
                        <div class="card-body text-white text-center info-card">
                            <h1 class="font-weight-normal m-0 mb-3"><i class="fas fa-wifi"></i></h1>
                            <h5 class="font-weight-normal m-0 ">Internet</h5>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="logout mt-5">
                    <a class="btn btn-warning mt-auto" href="{{ route('room.logout') }}">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('LOGOUT') }}
                    </a>
                    <form id="logout-form" action="{{ route('room.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @if (auth()->user()->room->device_id == 1)
                    <a href="/scan" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code-scan mr-2" viewBox="0 0 16 16">
                            <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z" />
                            <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z" />
                            <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z" />
                            <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z" />
                            <path d="M12 9h2V8h-2v1Z" />
                        </svg>SCAN
                    </a>
                    @endif

                    <!-- <span class="btn btn-primary" onclick="location.reload();"> REFRESH</span> -->
                </div>
            </div>
            <div class="col-md-2 py-4">

            </div>
            <div class="col-md-4 px-4 py-3">
                <h6 id="ct5" class="text-white font-weight-normal text-center"></h6>


                <div class="p-4 text-center d-flex justify-content-center">
                    <!-- @if ($QrCode != '')
                    <div class="qr-code-fly">
                        <div class="qr">
                            {{ $QrCode }}
                        </div>
                    </div>
                    @endif -->


                    <div class="text-center">
                        <div class="card">
                            <div class="card-body">
                                @if ($bookingOngoing->count() > 0)
                                {!! QrCode::size(150)->backgroundColor(255,90,0)->generate($linkQr) !!}



                            </div>
                        </div>
                        <h5> <span class="badge badge-success text-white mb4"> {{ $bookingOngoing[0]->title }}</span></h5>
                        @else
                        <h5> <span class="badge badge-danger text-white py-2 mb-4">Tidak ada meeting yang berlangsung</span></h5>
                        @endif

                    </div>


                </div>
                <div class="text-center mb-3 absent">
                </div>
                <div class="style-after-upcoming">
                    <h2 class="text-white text-center font-weight-normal">Today's Event</h2>
                    <div style="overflow: auto; height: 37vh;">
                        @if ($booking_today->count() > 0)
                        @foreach ($booking_today as $booking_todays)
                        <p id="rcorners2" class="text-white h6">* {!! Str::limit($booking_todays->title , 20, ' ...') !!} - {{\Carbon\Carbon::parse($booking_todays->start_date)->toFormattedDateString() }} <br>({{\Carbon\Carbon::parse($booking_todays->start_date)->diffForHumans() }})</p>

                        @endforeach

                        @else
                        <p id="rcorners3" class="text-white h6">Tidak ada event hari ini</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        setInterval(function() {
            window.location.reload();
        }, 30000);
    </script>

    <!-- <script>
        const vue = new Vue({
            el: '#app',
            data() {
                return {
                    message: 'ok',
                    meetingToday: '',
                }
            },
            mounted() {
                let counter = 1;
                setInterval(() => {
                    // counter += 1;
                    // this.meetingToday = "ok" + counter;
                    // if(counter % 2 == 0) {
                    // }
                    // if (counter % 2 == 0) {
                    //     const garisLED = document.querySelector('.garis-led');
                    //     // console.log(garisLED);
                    //     garisLED.style.backgroundColor = "red";
                    //     garisLED.style.border = "11px solid red";
                    // } else {
                    //     const garisLED = document.querySelector('.garis-led');
                    //     // console.log(garisLED);
                    //     garisLED.style.backgroundColor = "green";
                    //     garisLED.style.border = "11px solid green";
                    // }

                    this.updateMessage();
                    if (counter % 2 == 0) {
                        const garisLED = document.querySelector('.garis-led');
                        // console.log(garisLED);
                        garisLED.style.backgroundColor = "red";
                        garisLED.style.border = "11px solid red";
                    } else {
                        const garisLED = document.querySelector('.garis-led');
                        // console.log(garisLED);
                        garisLED.style.backgroundColor = "green";
                        garisLED.style.border = "11px solid green";
                    }
                }, 5000);
            },
            methods: {
                async updateMessage() {
                    try {
                        const response = await axios.get('{{ route("room.tes") }}');

                        if (response) {

                            const booking_today = response.data;
                        }

                        if (booking_today.booking_today.length > 0) {
                            this.meetingToday = booking_today[0];
                        } else {
                            this.meetingToday = 'Tidak Adaa aaaaaa'
                        }

                    } catch (error) {
                        console.log(response);
                    }
                }
            }
        })
    </script> -->


    <script type="text/javascript">
        function display_ct5() {
            var x = new Date()
            var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
            var x1 = x.getMonth() + 1 + "/" + x.getDate() + "/" + x.getFullYear();
            x1 = x1 + " - " + x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds() + ":" + ampm;
            document.getElementById('ct5').innerHTML = x1;
            display_c5();
        }

        function display_c5() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct5()', refresh)
        }
        display_c5()
        // $(document).ready(function() {
    </script>

    <script>
        var VBOOKIP = 'http://' + '{!! $ip !!}';
        // Set the date we're counting down to
        var countDownDate = new Date("{!! $end_date !!}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="getCountdown"
            document.getElementById("getCountdown").innerHTML = hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("getCountdown").innerHTML = "MEETING SELESAI";

                setInterval(function() {

                    axios.post(
                            `${VBOOKIP}:8080/v1/oauth2/token/`, {
                                grant_type: "password",
                                username: "admin",
                                password: "12345678"
                            })
                        .then((res) => {
                            let token = res.data.access_token;

                            const config = {
                                headers: {
                                    Authorization: `Bearer ${token}`
                                }
                            };

                            var paramsBody;

                            paramsBody = {
                                "red": 255,
                                "green": 0,
                                "blue": 0,
                            };
                            axios.post(`${VBOOKIP}:8080/v1/led/front_led/`,
                                    paramsBody, config)
                                .then((res) => {
                                    console.log(res)
                                })
                                .catch((err) => {
                                    console.log(`Error front led : ${err}`);
                                })
                            axios.post(`${VBOOKIP}:8080/v1/led/side_led/`,
                                    paramsBody, config)
                                .then((res) => {
                                    console.log(res);
                                })
                                .catch((err) => {
                                    console.log(`Error side led : ${err}`);
                                })
                        })
                        .catch((err) => {
                            console.log(`Error oauth2 token : ${err}`);
                        });

                }, 1000);
            }
        }, 1000);
    </script>

</body>

</html>
