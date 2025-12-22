<x-app-layout>
    @php
        $title = 'توزيع العملاء على فرق المبيعات';
    @endphp

    <style>
        .distribution-page {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .search-section {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .unassigned-section {
            background: white;
            border-radius: 0.5rem;
            border: 2px dashed #d1d5db;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .unassigned-section-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .unassigned-clients-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            min-height: 80px;
            padding: 1rem 0;
        }

        .teams-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .team-card {
            background: white;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            min-height: 300px;
            display: flex;
            flex-direction: column;
            transition: all 0.2s;
        }

        .team-card:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .team-header {
            padding: 1.25rem;
            border-bottom: 2px solid #e5e7eb;
            background: linear-gradient(to left, #f9fafb, #ffffff);
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .team-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .team-count {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .team-clients {
            flex: 1;
            padding: 1rem;
            min-height: 200px;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-content: flex-start;
        }

        .client-tag {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.625rem 0.875rem;
            background: linear-gradient(to left, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e40af;
            cursor: move;
            transition: all 0.2s;
            position: relative;
            min-width: fit-content;
        }

        .client-tag:hover {
            background: linear-gradient(to left, #dbeafe, #bfdbfe);
            transform: translateX(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .client-tag.dragging {
            opacity: 0.5;
            transform: scale(0.95);
        }

        .client-tag .remove-btn {
            margin-right: 0.5rem;
            padding: 0.125rem 0.375rem;
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .client-tag .remove-btn:hover {
            background: #fecaca;
        }


        .empty-team {
            text-align: center;
            padding: 2rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .team-card.drag-over {
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .unassigned-section.drag-over {
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .save-indicator {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            padding: 0.75rem 1.5rem;
            background: #10b981;
            color: white;
            border-radius: 0.5rem;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
        }

        .save-indicator.show {
            display: block;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .client-tag-company {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
    </style>

    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">توزيع العملاء على فرق المبيعات</h2>
        <p style="font-size: 1rem; color: #6b7280; margin: 0;">اسحب العملاء إلى الفرق المناسبة أو انقر لإزالتهم</p>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">إجمالي العملاء</div>
            <div style="font-size: 2rem; font-weight: 700; color: #111827;">{{ $totalCount }}</div>
        </div>
        <div style="background: linear-gradient(to left, #d1fae5, #a7f3d0); border-radius: 0.5rem; border: 1px solid #10b981; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; color: #065f46; margin-bottom: 0.5rem; font-weight: 500;">العملاء الموزعين</div>
            <div id="stat-assigned-count" style="font-size: 2rem; font-weight: 700; color: #065f46;">{{ $assignedCount }}</div>
        </div>
        <div style="background: linear-gradient(to left, #fef3c7, #fde68a); border-radius: 0.5rem; border: 1px solid #f59e0b; padding: 1.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; color: #92400e; margin-bottom: 0.5rem; font-weight: 500;">العملاء غير الموزعين</div>
            <div id="stat-unassigned-count" style="font-size: 2rem; font-weight: 700; color: #92400e;">{{ $unassignedCount }}</div>
        </div>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background-color: #d1fae5; color: #065f46; border-radius: 0.375rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="distribution-page">
        <!-- Search Section -->
        <div class="search-section">
            <input type="text" 
                   id="clientSearch" 
                   class="search-input" 
                   placeholder="ابحث عن عميل...">
        </div>

        <!-- Unassigned Clients Section -->
        <div class="unassigned-section" 
             data-team-id="unassigned"
             ondrop="dropClient(event)" 
             ondragover="allowDrop(event)"
             ondragleave="removeDragOver(event)">
            <div class="unassigned-section-header">
                <div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem;">عملاء غير مخصصين</div>
                    <div style="font-size: 0.875rem; color: #6b7280;">
                        <span id="unassigned-count">{{ $unassignedClients->count() }}</span> عميل
                    </div>
                </div>
            </div>
            <div class="unassigned-clients-container" id="unassigned-clients">
                @foreach($unassignedClients as $client)
                    <div class="client-tag" 
                         draggable="true"
                         ondragstart="dragClient(event)"
                         data-client-id="{{ $client->id }}"
                         data-client-name="{{ strtolower($client->name) }}">
                        <span>
                            {{ $client->name }}
                            @if($client->company)
                                <div class="client-tag-company">{{ $client->company }}</div>
                            @endif
                        </span>
                    </div>
                @endforeach
                @if($unassignedClients->count() == 0)
                    <div class="empty-team" style="width: 100%; text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem;">جميع العملاء مخصصين</div>
                @endif
            </div>
        </div>

        <!-- Teams Container -->
        <div class="teams-container">
            @foreach($salesTeams as $team)
                <div class="team-card" 
                     data-team-id="{{ $team->id }}"
                     ondrop="dropClient(event)" 
                     ondragover="allowDrop(event)"
                     ondragleave="removeDragOver(event)">
                    <div class="team-header">
                        <div class="team-title">{{ $team->name }}</div>
                        <div class="team-count">
                            <span id="team-{{ $team->id }}-count">{{ $team->clients->count() }}</span> عميل
                        </div>
                    </div>
                    <div class="team-clients" id="team-{{ $team->id }}-clients">
                        @foreach($team->clients as $client)
                            <div class="client-tag" 
                                 draggable="true"
                                 ondragstart="dragClient(event)"
                                 data-client-id="{{ $client->id }}"
                                 data-client-name="{{ strtolower($client->name) }}">
                                <span>
                                    {{ $client->name }}
                                    @if($client->company)
                                        <div class="client-tag-company">{{ $client->company }}</div>
                                    @endif
                                </span>
                                <button type="button" 
                                        class="remove-btn" 
                                        onclick="removeClientFromTeam({{ $client->id }}, {{ $team->id }})"
                                        title="إزالة من الفريق">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                        @if($team->clients->count() == 0)
                            <div class="empty-team" style="width: 100%;">لا يوجد عملاء في هذا الفريق</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="save-indicator" id="saveIndicator">تم الحفظ بنجاح</div>

    <script>
        let draggedClientId = null;
        let draggedClientElement = null;

        // Search functionality
        document.getElementById('clientSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const clientTags = document.querySelectorAll('.client-tag');
            
            clientTags.forEach(tag => {
                const clientName = tag.getAttribute('data-client-name');
                if (clientName.includes(searchTerm)) {
                    tag.style.display = 'flex';
                } else {
                    tag.style.display = 'none';
                }
            });
        });

        // Drag and Drop functions
        function dragClient(event) {
            draggedClientId = event.target.getAttribute('data-client-id');
            draggedClientElement = event.target;
            event.target.classList.add('dragging');
            event.dataTransfer.effectAllowed = 'move';
        }

        function allowDrop(event) {
            event.preventDefault();
            event.currentTarget.classList.add('drag-over');
        }

        function removeDragOver(event) {
            event.currentTarget.classList.remove('drag-over');
        }

        function dropClient(event) {
            event.preventDefault();
            event.currentTarget.classList.remove('drag-over');
            
            const targetTeamId = event.currentTarget.getAttribute('data-team-id');
            
            if (!draggedClientId || !draggedClientElement) return;
            
            // Remove client from old location
            draggedClientElement.remove();
            
            // Add client to new team
            const targetClientsContainer = document.getElementById(`team-${targetTeamId}-clients`) || 
                                          document.getElementById('unassigned-clients');
            
            // Create new client tag
            const clientName = draggedClientElement.querySelector('span').textContent.trim();
            const clientCompany = draggedClientElement.querySelector('.client-tag-company')?.textContent;
            
            const newClientTag = document.createElement('div');
            newClientTag.className = 'client-tag';
            newClientTag.setAttribute('draggable', 'true');
            newClientTag.setAttribute('ondragstart', 'dragClient(event)');
            newClientTag.setAttribute('data-client-id', draggedClientId);
            newClientTag.setAttribute('data-client-name', clientName.toLowerCase());
            
            let innerHTML = `<span>${clientName}`;
            if (clientCompany) {
                innerHTML += `<div class="client-tag-company">${clientCompany}</div>`;
            }
            innerHTML += `</span>`;
            
            if (targetTeamId !== 'unassigned') {
                innerHTML += `<button type="button" class="remove-btn" onclick="removeClientFromTeam(${draggedClientId}, ${targetTeamId})" title="إزالة من الفريق">✕</button>`;
            }
            
            newClientTag.innerHTML = innerHTML;
            
            // Remove empty message if exists
            const emptyMessage = targetClientsContainer.querySelector('.empty-team');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            targetClientsContainer.appendChild(newClientTag);
            
            // Update counts
            updateTeamCounts();
            
            // Save to database
            saveClientDistribution(draggedClientId, targetTeamId);
            
            // Reset
            draggedClientElement.classList.remove('dragging');
            draggedClientId = null;
            draggedClientElement = null;
        }

        function removeClientFromTeam(clientId, teamId) {
            if (!confirm('هل أنت متأكد من إزالة هذا العميل من الفريق؟')) {
                return;
            }
            
            const clientTag = document.querySelector(`[data-client-id="${clientId}"]`);
            if (!clientTag) return;
            
            // Remove from current team
            clientTag.remove();
            
            // Add to unassigned
            const unassignedContainer = document.getElementById('unassigned-clients');
            const clientName = clientTag.querySelector('span').textContent.trim();
            const clientCompany = clientTag.querySelector('.client-tag-company')?.textContent;
            
            const newClientTag = document.createElement('div');
            newClientTag.className = 'client-tag';
            newClientTag.setAttribute('draggable', 'true');
            newClientTag.setAttribute('ondragstart', 'dragClient(event)');
            newClientTag.setAttribute('data-client-id', clientId);
            newClientTag.setAttribute('data-client-name', clientName.toLowerCase());
            
            let innerHTML = `<span>${clientName}`;
            if (clientCompany) {
                innerHTML += `<div class="client-tag-company">${clientCompany}</div>`;
            }
            innerHTML += `</span>`;
            newClientTag.innerHTML = innerHTML;
            
            const emptyMessage = unassignedContainer.querySelector('.empty-team');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            unassignedContainer.appendChild(newClientTag);
            
            // Update counts
            updateTeamCounts();
            
            // Save to database (remove from team)
            saveClientDistribution(clientId, 'unassigned');
        }

        function updateTeamCounts() {
            // Update all team counts
            let totalAssigned = 0;
            
            @foreach($salesTeams as $team)
                const team{{ $team->id }}Clients = document.querySelectorAll(`#team-{{ $team->id }}-clients .client-tag`).length;
                document.getElementById('team-{{ $team->id }}-count').textContent = team{{ $team->id }}Clients;
                totalAssigned += team{{ $team->id }}Clients;
                
                // Show empty message if needed
                const team{{ $team->id }}Container = document.getElementById('team-{{ $team->id }}-clients');
                if (team{{ $team->id }}Clients === 0 && !team{{ $team->id }}Container.querySelector('.empty-team')) {
                    const emptyMsg = document.createElement('div');
                    emptyMsg.className = 'empty-team';
                    emptyMsg.textContent = 'لا يوجد عملاء في هذا الفريق';
                    team{{ $team->id }}Container.appendChild(emptyMsg);
                }
            @endforeach
            
            // Update unassigned count
            const unassignedClients = document.querySelectorAll('#unassigned-clients .client-tag').length;
            document.getElementById('unassigned-count').textContent = unassignedClients;
            
            const unassignedContainer = document.getElementById('unassigned-clients');
            if (unassignedClients === 0 && !unassignedContainer.querySelector('.empty-team')) {
                const emptyMsg = document.createElement('div');
                emptyMsg.className = 'empty-team';
                emptyMsg.style.cssText = 'width: 100%; text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem;';
                emptyMsg.textContent = 'جميع العملاء مخصصين';
                unassignedContainer.appendChild(emptyMsg);
            }
            
            // Update statistics cards
            updateStatisticsCards(totalAssigned, unassignedClients);
        }

        function updateStatisticsCards(assignedCount, unassignedCount) {
            // Update assigned count if element exists
            const assignedElement = document.getElementById('stat-assigned-count');
            if (assignedElement) {
                assignedElement.textContent = assignedCount;
            }
            
            // Update unassigned count if element exists
            const unassignedElement = document.getElementById('stat-unassigned-count');
            if (unassignedElement) {
                unassignedElement.textContent = unassignedCount;
            }
        }

        function saveClientDistribution(clientId, teamId) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            
            if (teamId !== 'unassigned') {
                formData.append('sales_team_ids[]', teamId);
            }
            
            fetch(`/client-distribution/${clientId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSaveIndicator();
                } else {
                    throw new Error(data.message || 'حدث خطأ أثناء الحفظ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء الحفظ. يرجى المحاولة مرة أخرى.');
            });
        }

        function showSaveIndicator() {
            const indicator = document.getElementById('saveIndicator');
            indicator.classList.add('show');
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 2000);
        }

        // Prevent default drag behavior on images and buttons
        document.addEventListener('dragstart', function(e) {
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'IMG') {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>
