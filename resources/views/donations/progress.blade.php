@if (App\Helpers\Donations::donationCycleRatio())
<div class="flex flex-row justify-end items-center donation-progress container_v2 mx-auto">
    <div>Donation</div>
    <div class="full-bar">
        <div class="progress" style="width: {{App\Helpers\Donations::donationCycleRatio() * 100}}%">
        </div>
    </div>
</div>
<style>
    .full-bar {
        width: 250px;
        height: 15px;
        background: #cece91;
        border-radius: 1px;
    }

    .full-bar>.progress {
        height: 100%;
        background: green;
    }
</style>
@endif
