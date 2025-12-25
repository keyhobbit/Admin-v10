<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Welcome to AFK Game CMS',
                'slug' => 'welcome-to-afk-game-cms',
                'excerpt' => 'Discover the exciting world of idle RPG gaming with our new platform. Learn about all the amazing features we have prepared for you.',
                'content' => '<h2>Welcome to Our Platform!</h2><p>We are thrilled to announce the launch of our AFK Game CMS platform. This is your one-stop destination for all things related to idle RPG gaming.</p><h3>What We Offer</h3><ul><li>Comprehensive game guides and tutorials</li><li>Latest news and updates</li><li>Community events and challenges</li><li>Expert tips and strategies</li></ul><p>Join us on this exciting journey and become part of our growing gaming community!</p>',
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&h=400&fit=crop',
                'category' => 'Announcements',
                'author' => 'Game Master',
                'status' => 'published',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Top 10 Heroes You Need in 2025',
                'slug' => 'top-10-heroes-guide-2025',
                'excerpt' => 'Check out our comprehensive guide to the most powerful heroes in the game right now. Tier list updated for the current meta.',
                'content' => '<h2>The Ultimate Hero Tier List</h2><p>After extensive testing and community feedback, we have compiled the definitive list of top-tier heroes for 2025.</p><h3>S-Tier Heroes</h3><ol><li><strong>Shadow Assassin</strong> - Incredible burst damage and mobility</li><li><strong>Holy Paladin</strong> - Best tank with amazing sustain</li><li><strong>Arcane Mage</strong> - Unmatched AoE damage dealer</li></ol><h3>A-Tier Heroes</h3><ol start="4"><li><strong>Forest Ranger</strong> - Consistent DPS with crowd control</li><li><strong>Divine Healer</strong> - Essential for difficult content</li></ol><p>Stay tuned for detailed guides on each hero coming soon!</p>',
                'image' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=800&h=400&fit=crop',
                'category' => 'Guides',
                'author' => 'Strategy Expert',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'December Update - New Features and Content!',
                'slug' => 'december-update-patch-notes',
                'excerpt' => 'Explore all the exciting new features, heroes, and improvements in our latest December update. Patch notes inside!',
                'content' => '<h2>December Update is Live!</h2><p>We are excited to bring you the biggest update of the year with tons of new content and quality of life improvements.</p><h3>New Features</h3><ul><li>3 New Heroes: Frost Knight, Thunder Warrior, and Mystic Enchantress</li><li>New Game Mode: Guild vs Guild Battles</li><li>Equipment Enhancement System</li><li>Daily Login Rewards Revamp</li></ul><h3>Balance Changes</h3><ul><li>Shadow Assassin: Base attack increased by 5%</li><li>Holy Paladin: Shield duration increased by 2 seconds</li><li>Arcane Mage: Mana cost reduced for all skills</li></ul><h3>Bug Fixes</h3><ul><li>Fixed issue where some heroes would not attack automatically</li><li>Resolved rewards not being distributed properly</li><li>Performance optimization for older devices</li></ul><p>Thank you for your continued support!</p>',
                'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800&h=400&fit=crop',
                'category' => 'Updates',
                'author' => 'Dev Team',
                'status' => 'published',
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Winter Festival Event - Exclusive Rewards!',
                'slug' => 'winter-festival-event-2025',
                'excerpt' => 'Join our Winter Festival celebration and earn exclusive limited-time rewards, including rare heroes and legendary equipment!',
                'content' => '<h2>Winter Festival is Here!</h2><p>Celebrate the season with our special Winter Festival event running from December 20th to January 5th!</p><h3>Event Activities</h3><ul><li><strong>Daily Quests:</strong> Complete special winter-themed missions</li><li><strong>Boss Rush:</strong> Defeat the Ice Dragon for epic loot</li><li><strong>Lucky Draw:</strong> Spin daily for a chance to win legendary heroes</li></ul><h3>Exclusive Rewards</h3><ul><li>Limited Edition: Snow Queen Hero</li><li>Legendary Equipment: Frostbite Sword</li><li>Special Winter Skins for your favorite heroes</li><li>200% EXP Boost Potions</li></ul><h3>How to Participate</h3><p>Simply log in during the event period and check the Events tab. Complete daily missions to earn Snowflake Tokens which can be exchanged for amazing rewards!</p><p>Don\'t miss this limited-time opportunity!</p>',
                'image' => 'https://images.unsplash.com/photo-1482498542409-d5f7a9b42f7f?w=800&h=400&fit=crop',
                'category' => 'Events',
                'author' => 'Event Coordinator',
                'status' => 'published',
                'published_at' => now()->subHours(6),
            ],
            [
                'title' => 'Beginner\'s Guide: Getting Started in AFK Game',
                'slug' => 'beginners-guide-getting-started',
                'excerpt' => 'New to the game? This comprehensive beginner\'s guide will help you understand the basics and get you started on the right path.',
                'content' => '<h2>Welcome, New Player!</h2><p>Starting a new idle RPG can be overwhelming, but don\'t worry - we\'ve got you covered with this comprehensive guide.</p><h3>First Steps</h3><ol><li><strong>Complete the Tutorial:</strong> Don\'t skip it! You\'ll learn essential mechanics</li><li><strong>Choose Your Starting Hero:</strong> We recommend the Holy Paladin for beginners</li><li><strong>Join a Guild:</strong> Early guild membership provides valuable resources</li></ol><h3>Resource Management</h3><p>The key to success in AFK Game is managing your resources wisely:</p><ul><li><strong>Gold:</strong> Use for hero upgrades and equipment</li><li><strong>Gems:</strong> Save for hero summons during events</li><li><strong>Experience Potions:</strong> Use on your main team only</li></ul><h3>Team Building Tips</h3><ul><li>Focus on one team of 5 heroes initially</li><li>Balance your team: 1 Tank, 1 Healer, 3 Damage Dealers</li><li>Upgrade equipment regularly</li></ul><h3>Daily Routine</h3><ol><li>Collect AFK rewards</li><li>Complete daily quests</li><li>Fight in Arena (3 attempts minimum)</li><li>Do Guild Boss battle</li></ol><p>Follow these tips and you\'ll progress quickly!</p>',
                'image' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=800&h=400&fit=crop',
                'category' => 'Guides',
                'author' => 'Tutorial Master',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Advanced Strategy: Optimal Team Compositions',
                'slug' => 'advanced-strategy-team-compositions',
                'excerpt' => 'Master the art of team building with our advanced guide to creating powerful synergistic team compositions for different game modes.',
                'content' => '<h2>Team Composition Mastery</h2><p>Once you\'ve mastered the basics, it\'s time to dive deep into team synergies and optimal compositions.</p><h3>PvE Composition (Campaign)</h3><p><strong>Tank:</strong> Holy Paladin<br><strong>Healer:</strong> Divine Healer<br><strong>DPS 1:</strong> Shadow Assassin (Single Target)<br><strong>DPS 2:</strong> Arcane Mage (AoE)<br><strong>Support:</strong> Forest Ranger (Crowd Control)</p><h3>PvP Composition (Arena)</h3><p><strong>Tank:</strong> Iron Defender<br><strong>Burst DPS:</strong> Shadow Assassin<br><strong>Sustain DPS:</strong> Blood Vampire<br><strong>Control:</strong> Ice Witch<br><strong>Support:</strong> War Buffer</p><h3>Boss Killing Composition</h3><p>For high-damage single target scenarios:</p><ul><li>2 Tanks for survivability</li><li>1 Healer with cleanse abilities</li><li>2 Pure Single Target DPS heroes</li></ul><h3>Key Synergies</h3><ul><li><strong>Faction Bonus:</strong> Using 3+ heroes from same faction grants stat boost</li><li><strong>Elemental Advantage:</strong> Fire > Nature > Water > Fire</li><li><strong>Control Chain:</strong> Stack stuns and freezes for lockdown</li></ul><p>Experiment with different combinations and find what works best for your playstyle!</p>',
                'image' => 'https://images.unsplash.com/photo-1556438064-2d7646166914?w=800&h=400&fit=crop',
                'category' => 'Guides',
                'author' => 'Strategy Expert',
                'status' => 'published',
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'Community Spotlight: Player Achievements',
                'slug' => 'community-spotlight-december',
                'excerpt' => 'Celebrating our amazing community! Check out the incredible achievements and milestones reached by our players this month.',
                'content' => '<h2>Celebrating Our Community</h2><p>This month we want to highlight some incredible achievements from our player community!</p><h3>Top Performers</h3><ul><li><strong>DarkKnight92:</strong> First player to clear Chapter 50!</li><li><strong>MageQueen:</strong> Achieved #1 Arena ranking for 3 consecutive weeks</li><li><strong>GuildMaster777:</strong> Led guild to top 10 in Guild Wars</li></ul><h3>Creative Highlights</h3><p>We loved seeing your fan art, team compositions, and strategy guides shared on social media. Special mention to:</p><ul><li><strong>ArtistGamer:</strong> Amazing hero artwork series</li><li><strong>StrategyPro:</strong> Comprehensive F2P progression guide</li><li><strong>VideoCreator:</strong> Entertaining gameplay commentary videos</li></ul><h3>Helpful Community Members</h3><p>Shoutout to our Discord moderators and helpful community members who make our game community welcoming for everyone!</p><h3>Share Your Story</h3><p>Want to be featured in next month\'s spotlight? Share your achievements with hashtag #AFKGameWin on social media or in our Discord server!</p>',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop',
                'category' => 'Announcements',
                'author' => 'Community Manager',
                'status' => 'published',
                'published_at' => now()->subHours(3),
            ],
            [
                'title' => 'Equipment Guide: Understanding Gear Stats',
                'slug' => 'equipment-guide-gear-stats',
                'excerpt' => 'Learn everything about equipment stats, how to optimize your gear, and which stats are best for each hero class.',
                'content' => '<h2>Master Your Equipment</h2><p>Equipment can make or break your heroes. Understanding stats is crucial for optimization.</p><h3>Primary Stats</h3><ul><li><strong>ATK (Attack):</strong> Increases physical damage</li><li><strong>DEF (Defense):</strong> Reduces physical damage taken</li><li><strong>HP (Health Points):</strong> Total health pool</li><li><strong>SPD (Speed):</strong> Action frequency and dodge chance</li><li><strong>CRIT:</strong> Critical hit chance</li></ul><h3>Equipment Slots</h3><ol><li><strong>Weapon:</strong> Main ATK source</li><li><strong>Armor:</strong> Primary DEF stat</li><li><strong>Helmet:</strong> HP and DEF</li><li><strong>Boots:</strong> SPD and dodge</li><li><strong>Accessory:</strong> Special effects and bonuses</li></ol><h3>Stat Priority by Role</h3><p><strong>Damage Dealers:</strong> ATK > CRIT > SPD<br><strong>Tanks:</strong> HP > DEF > SPD<br><strong>Healers:</strong> SPD > HP > DEF<br><strong>Support:</strong> SPD > ATK > HP</p><h3>Enhancement Tips</h3><ul><li>Focus on upgrading your main team\'s equipment first</li><li>+15 enhancement is sufficient for early game</li><li>Save legendary enhancement materials for best-in-slot gear</li><li>Set bonuses matter! Try to complete full sets</li></ul><h3>Where to Farm</h3><ul><li><strong>Early Game:</strong> Campaign stages</li><li><strong>Mid Game:</strong> Equipment dungeons</li><li><strong>Late Game:</strong> Raid bosses and Guild Shop</li></ul>',
                'image' => 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=800&h=400&fit=crop',
                'category' => 'Guides',
                'author' => 'Equipment Expert',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }

        $this->command->info('Created ' . count($blogs) . ' sample blog posts!');
    }
}
