import { Controller } from '@hotwired/stimulus';

const RESTART_DELAY_MS = 1000;
const SYNC_THRESHOLD_SECONDS = 0.15;
const END_BUFFER_SECONDS = 0.2;

export default class extends Controller {
    static targets = ['video'];

    connect()
    {
        const [leader, ...followers] = this.videoTargets;
        this.leader = leader;
        this.followers = followers;
        this.restarting = false;

        this.leader.addEventListener('timeupdate', () => this.handleTimeUpdate());
    }

    handleTimeUpdate()
    {
        if (this.restarting) {
            return;
        }

        if (this.leader.duration && this.leader.currentTime >= this.leader.duration - END_BUFFER_SECONDS) {
            this.pauseThenRestart();

            return;
        }

        this.syncFollowers();
    }

    syncFollowers()
    {
        for (const video of this.followers) {
            if (Math.abs(video.currentTime - this.leader.currentTime) > SYNC_THRESHOLD_SECONDS) {
                video.currentTime = this.leader.currentTime;
            }
        }
    }

    pauseThenRestart()
    {
        this.restarting = true;

        for (const video of this.videoTargets) {
            video.pause();
            video.currentTime = 0;
        }

        setTimeout(() => {
            for (const video of this.videoTargets) {
                void video.play().catch(() => {});
            }
            this.restarting = false;
        }, RESTART_DELAY_MS);
    }
}
