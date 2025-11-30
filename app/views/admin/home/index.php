<div class="space-y-8">

    <!-- 🧮 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-pink-400 to-rose-500 text-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-sm opacity-80">Total Categories</h2>
            <p class="text-4xl font-bold mt-2"><?= count($categories) ?></p>
        </div>
        <div class="bg-gradient-to-r from-rose-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-sm opacity-80">Total Posts</h2>
            <p class="text-4xl font-bold mt-2"><?= count($posts) ?></p>
        </div>
        <div class="bg-gradient-to-r from-purple-400 to-indigo-500 text-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-sm opacity-80">Visitors Today</h2>
            <p class="text-4xl font-bold mt-2">1,248</p>
        </div>
        <div class="bg-gradient-to-r from-blue-400 to-cyan-500 text-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-sm opacity-80">Conversion Rate</h2>
            <p class="text-4xl font-bold mt-2">12%</p>
        </div>
    </div>

    <!-- 📊 Chart Section -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <span>📈</span> Traffic Overview
        </h2>
        <canvas id="trafficChart" height="120"></canvas>
    </div>

    <!-- 📰 Recent Posts -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <span>📝</span> Recent Posts
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-100 rounded-lg overflow-hidden">
                <thead class="bg-pink-50 text-pink-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Category</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 font-medium"><?= htmlspecialchars($post['title']) ?></td>
                            <td class="px-4 py-2 text-gray-600"><?= htmlspecialchars($post['category_name'] ?? '—') ?></td>
                            <td class="px-4 py-2">
                                <?php if (($post['status'] ?? '') === 'published'): ?>
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Published</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-gray-500"><?= htmlspecialchars($post['post_date'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ⚙️ System Info -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <span>⚙️</span> System Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-700">
            <div><strong>PHP Version:</strong> <?= phpversion() ?></div>
            <div><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></div>
            <div><strong>Database:</strong> MySQL</div>
            <div><strong>App Path:</strong> <?= basename(__DIR__) ?></div>
            <div><strong>Current User:</strong> Admin</div>
            <div><strong>Last Login:</strong> <?= date('d/m/Y H:i') ?></div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('trafficChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitors',
            data: [120, 190, 300, 500, 200, 300, 450],
            fill: true,
            borderColor: '#ec4899',
            backgroundColor: 'rgba(236, 72, 153, 0.15)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
