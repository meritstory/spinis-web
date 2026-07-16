import { Controller } from '@hotwired/stimulus';

const RESTART_DELAY_MS = 1000;
const SYNC_THRESHOLD_SECONDS = 0.15;

export default class extends Controller {
    static targets = ['video'];

    connect() {
        const [leader, ...followers] = this.videoTargets;
        this.leader = leader;
        this.followers = followers;

        this.leader.addEventListener('timeupdate', () => this.syncFollowers());
        this.leader.addEventListener('ended', () => this.restartAfterPause());
    }

    syncFollowers() {
        for (const video of this.followers) {
            if (Math.abs(video.currentTime - this.leader.currentTime) > SYNC_THRESHOLD_SECONDS) {
                video.currentTime = this.leader.currentTime;
            }
        }
    }

    restartAfterPause() {
        setTimeout(() => {
            for (const video of this.videoTargets) {
                video.currentTime = 0;
                void video.play().catch(() => {});
            }
        }, RESTART_DELAY_MS);
    }
}
