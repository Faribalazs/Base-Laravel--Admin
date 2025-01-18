<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

<div class="main-div">
    <div class="secondary-div">
        <div class="white-div">
            <div class="logo-div">
                <x-application-logo class="block h-10 w-auto fill-current" />
            </div>
            <div class="text-div">
               <span class="text-title">{{__('app.email.title')}}</span>
               <span class="text-content">{{__('app.email.verification-text')}}</span>
            </div>
            <div class="btn-div">
                <a href="{{ $url }}" class="verify-btn">Verify email address</a>
            </div>
            <div class="text-div" style="margin-bottom: 35px;">
                <span class="text-content">{{__('app.email.verification-hint')}}</span>
            </div>
            <div class="text-div">
                <span class="text-content">{{__('app.email.regards')}},</span>
                <span class="text-title">{{ config('app.name') }}</span>
             </div>
        </div>
    </div>
</div>
<style>
    .main-div {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }

    .secondary-div {
        display: flex;
        justify-content: center;
        flex-direction: column
    }

    .white-div {
        width: 80%;
        background-color: white;
        margin: auto;
        border-radius: 25px;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
    }

    .logo-div {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .btn-div {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .text-div {
        display: flex;
        justify-content: center;
        width: 80%;
        margin: auto;
        flex-direction: column;
        margin-bottom: 30px;
    }

    .verify-btn {
        text-decoration: none;
        justify-content: center;
        font-family: Poppins;
        text-align: center;
        display: flex;
        align-items: center;
        background-color: #0d2c5a;
        color: #F3F8FF;
        font-size: 18px;
        font-weight: 700;
        padding: 10px 30px 10px 30px;
        border-radius: 25px;
        width: 40%;
    }

    .text-title {
        font-family: Poppins;
        font-weight: 700;
        font-size: 20px;
    }

    .text-content {
        font-family: Poppins;
        font-size: 18px;
    }

    @media (max-width: 640px) {
        .white-div {
            width: 95% !important;
        }
    }
</style>
